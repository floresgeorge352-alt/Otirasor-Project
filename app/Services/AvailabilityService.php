<?php

namespace App\Services;

use App\Models\Accommodation;
use App\Models\Booking;
use App\Models\ReservationHold;
use Carbon\Carbon;
use Illuminate\Support\Collection;

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
            ->whereIn('status', ['Pending', 'Confirmed'])
            ->when($excludeBookingId, fn ($q) => $q->where('id', '!=', $excludeBookingId))
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->with('accommodations:id')
            ->get()
            ->flatMap(fn ($b) => $b->accommodations->pluck('id'))
            ->unique()
            ->values()
            ->all();

        $held = ReservationHold::query()
            ->active()
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
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
}