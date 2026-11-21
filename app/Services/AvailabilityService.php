<?php

namespace App\Services;

use App\Events\AccommodationAvailabilityChanged;
use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\ReservationHold;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AvailabilityService
{
    /**
     * Return array of accommodation IDs that are unavailable
     * for the given date range (booked OR held).
     */
    public function unavailableAccommodationIds(
        string $checkIn,
        string $checkOut,
        ?int $excludeBookingId = null
    ): array {
        ReservationHold::expireStale();

        $booked = Booking::query()
            ->whereIn('status', ['Pending', 'Confirmed', 'Checked In', 'Pending Cancellation'])
            ->when($excludeBookingId, fn ($q) => $q->where('id', '!=', $excludeBookingId))
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->get()
            ->flatMap(function ($b) {
                // Use relationship method (with parentheses) para hindi ma-override ng legacy string attribute
                $ids = $b->accommodations()->pluck('accommodations.id')->toArray();

                // Fallback: comma-separated names from legacy attribute
                if (empty($ids)) {
                    $raw = $b->getAttributes()['accommodations'] ?? null;
                    if ($raw) {
                        $names = array_filter(array_map('trim', explode(',', $raw)));
                        $ids = Accommodation::whereIn('name', $names)->pluck('id')->toArray();
                    }
                }

                return $ids;
            })
            ->unique()
            ->values()
            ->all();

        // Kunin ang kasalukuyang user at session
        $currentUserId = Auth::id();
        $currentSessionId = session()->getId();

        $held = ReservationHold::query()
            ->active()
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            // I-ignore ang sariling hold ng customer na nagbo-book ngayon
            ->where(function ($q) use ($currentUserId, $currentSessionId) {
                // Kung may user, wag isama ang hold niya
                if ($currentUserId) {
                    $q->where('user_id', '!=', $currentUserId);
                }
                // Kung walang user (guest), check ang session_id
                if (!$currentUserId && $currentSessionId) {
                    $q->where('session_id', '!=', $currentSessionId);
                }
            })
            ->get()
            ->flatMap(fn ($h) => $h->accommodation_ids ?? [])
            ->unique()
            ->values()
            ->all();

        return array_values(array_unique(array_merge($booked, $held)));
    }

    /**
     * Check if any selected accommodation conflicts with
     * an active booking or hold for the given range.
     */
    public function hasConflict(
        array $accommodationIds,
        string $checkIn,
        string $checkOut,
        ?int $excludeBookingId = null
    ): bool {
        if (empty($accommodationIds)) {
            return false;
        }

        $unavailable = $this->unavailableAccommodationIds(
            $checkIn,
            $checkOut,
            $excludeBookingId
        );

        return count(array_intersect($accommodationIds, $unavailable)) > 0;
    }

    /**
     * Build a per-accommodation availability map for the
     * given date range. Returns array keyed by accommodation ID
     * with ['available' => bool, 'status' => string].
     */
    public function map(
        string $checkIn,
        string $checkOut,
        ?Collection $accommodations = null
    ): array {
        $accommodations = $accommodations
            ?? Accommodation::orderBy('type')->orderBy('name')->get();

        $unavailable = $this->unavailableAccommodationIds($checkIn, $checkOut);
        $unavailable = array_flip($unavailable);

        $map = [];

        foreach ($accommodations as $accommodation) {
            $blocked = isset($unavailable[$accommodation->id]);

            $available = $accommodation->status === 'available' && ! $blocked;

            $map[$accommodation->id] = [
                'available' => $available,
                'status' => $accommodation->status,
                'blocked_by_reservation' => $blocked,
            ];
        }

        return $map;
    }

    /**
     * Compute a numeric hash of availability for the given range.
     * Used by the public API so the frontend can detect changes
     * without re-fetching the full list.
     */
    public function hash(string $checkIn, string $checkOut): string
    {
        $map = $this->map($checkIn, $checkOut);
        ksort($map);

        return md5(json_encode($map));
    }

    /**
     * Broadcast availability change for a single accommodation.
     */
    public function notifyChange(int $accommodationId, bool $available): void
    {
        broadcast(new AccommodationAvailabilityChanged($accommodationId, $available));
    }

    /**
     * Broadcast availability change for all accommodations in a booking.
     * Called after approve / reject / checkout / cancel / no-show.
     */
    public function notifyBooking(Booking $booking, bool $available): void
    {
        $rooms = $booking->accommodations()->get();

        if ($rooms->isNotEmpty()) {
            foreach ($rooms as $room) {
                $this->notifyChange($room->id, $available);
            }
            return;
        }

        // Fallback: comma-separated accommodation names
        $names = array_filter(array_map('trim', explode(',', $booking->accommodations ?? '')));
        if (empty($names)) {
            return;
        }

        $ids = Accommodation::whereIn('name', $names)->pluck('id');
        foreach ($ids as $id) {
            $this->notifyChange((int) $id, $available);
        }
    }
}