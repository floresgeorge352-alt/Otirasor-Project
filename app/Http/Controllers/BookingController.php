<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\User;
use App\Models\Accommodation;
use App\Models\Fee;
use App\Models\ReservationHold;
use App\Notifications\NewBookingNotification;
use App\Notifications\CancellationRequestedNotification;
use App\Services\AvailabilityService;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function __construct(private AvailabilityService $availability) {}

    public function create(Request $request)
    {
        $accommodations = $request->query('accommodations', '');
        $accommodations = array_filter(explode(',', $accommodations));
        $checkIn = $request->query('check_in', '');
        $checkOut = $request->query('check_out', '');

        $selectedAccommodations = Accommodation::whereIn('name', $accommodations)->get();

        $accommodationBreakdown = [];

        foreach ($accommodations as $selectedName) {
            $accommodation = $selectedAccommodations->firstWhere('name', $selectedName);

            if ($accommodation) {
                $accommodationBreakdown[] = [
                    'name' => $accommodation->name,
                    'price' => (float) $accommodation->price,
                    'type' => $accommodation->type ?? null,
                ];
            }
        }

        $accommodationTotal = $selectedAccommodations->sum('price');

        $userRewardPoints = auth()->check()
            ? (auth()->user()->reward_points ?? 0)
            : 0;

        // Current active entrance and swimming fees
        $entranceAdultFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $entranceChildFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        $swimmingAdultFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $swimmingChildFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        // Check kung may active promos
        $hasActivePromos = \App\Models\Promotion::where('is_active', true)
            ->where('valid_until', '>=', now()->toDateString())
            ->exists();

        return view('booking', compact(
            'accommodations',
            'selectedAccommodations',
            'accommodationBreakdown',
            'accommodationTotal',
            'checkIn',
            'checkOut',
            'userRewardPoints',
            'entranceAdultFee',
            'entranceChildFee',
            'swimmingAdultFee',
            'swimmingChildFee',
            'hasActivePromos' // <-- Idinagdag ito
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guest_name' => 'required',
            'contact_number' => 'required',
            'number_of_adults' => 'required|integer|min:1',
            'number_of_kids' => 'required|integer|min:0',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'payment_method' => 'required|in:GCash',

            'gcash_reference' => [
                'nullable',
                'required_if:payment_method,GCash',
                'digits:13',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $existing = Booking::where('gcash_reference', $value)->first();

                        if ($existing && $existing->user_id !== auth()->id()) {
                            $fail('The GCash reference number has already been used by another account.');
                        }
                    }
                },
            ],

            'gcash_proof' => 'nullable|required_if:payment_method,GCash|image|mimes:jpg,jpeg,png|max:5120',
            'accommodations' => 'required|array|min:1',
            'swimming_pool' => 'nullable|boolean',
            'pool_adults' => 'nullable|integer|min:0',
            'pool_kids' => 'nullable|integer|min:0',
            'promo_code' => 'nullable|string|max:50',
            'use_rewards' => 'nullable|boolean',
        ]);

        $selectedAccommodations = Accommodation::whereIn(
            'name',
            $request->accommodations
        )->get();

        // Check accommodation availability
        $conflict = $this->availability->hasConflict(
            $selectedAccommodations->pluck('id')->all(),
            $request->check_in,
            $request->check_out
        );

        if ($conflict) {
            return back()
                ->withInput()
                ->with('error', 'One or more of the selected accommodations are already booked or on hold for those dates.');
        }

        $totalGuests = (int) $request->number_of_adults
            + (int) $request->number_of_kids;

        $accommodationTotal = $selectedAccommodations->sum('price');

        $numberOfAdults = (int) $request->number_of_adults;
        $numberOfKids = (int) $request->number_of_kids;

        // =========================================
        // DYNAMIC ENTRANCE FEES
        // =========================================

        $entranceAdultFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $entranceChildFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        $beachEntranceTotal =
            ($numberOfAdults * $entranceAdultFee) +
            ($numberOfKids * $entranceChildFee);

        // =========================================
        // SWIMMING POOL GUEST COUNTS
        // =========================================

        $poolAdults = (int) ($request->pool_adults ?? 0);
        $poolKids = (int) ($request->pool_kids ?? 0);

        if (!$request->boolean('swimming_pool')) {
            $poolAdults = 0;
            $poolKids = 0;
        }

        if ($poolAdults > $numberOfAdults) {
            return back()
                ->withInput()
                ->with('error', 'The number of adult swimmers cannot exceed the number of adult guests.');
        }

        if ($poolKids > $numberOfKids) {
            return back()
                ->withInput()
                ->with('error', 'The number of kid swimmers cannot exceed the number of kid guests.');
        }

        // =========================================
        // DYNAMIC SWIMMING FEES
        // =========================================

        $swimmingAdultFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $swimmingChildFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        $poolTotal =
            ($poolAdults * $swimmingAdultFee) +
            ($poolKids * $swimmingChildFee);

        $facilityTotal = $beachEntranceTotal + $poolTotal;

        // =========================================
        // PROMO CODE LOGIC
        // =========================================

        $discountAmount = 0;
        $promoCode = null;

        if ($request->filled('promo_code')) {
            $submittedPromo = strtoupper(trim($request->promo_code));

            $promo = \App\Models\Promotion::where('code', $submittedPromo)
                ->where('is_active', true)
                ->where('valid_until', '>=', now()->toDateString())
                ->first();

            if ($promo) {
                $promoCode = $promo->code;

                $subtotal = $accommodationTotal + $facilityTotal;

                $discountAmount =
                    ($subtotal * (float) $promo->discount_percentage) / 100;
            }
        }

        // =========================================
        // REWARDS LOGIC
        // =========================================

        $rewardPointsUsed = 0;
        $rewardDiscount = 0;

        if ($request->boolean('use_rewards') && auth()->check()) {
            $user = auth()->user();
            $availablePoints = $user->reward_points ?? 0;

            if ($availablePoints >= 100) {
                $subtotal = ($accommodationTotal + $facilityTotal) - $discountAmount;

                $rawRewardDiscount = ($availablePoints / 100) * 5;

                $rewardDiscount = min($rawRewardDiscount, $subtotal);

                $rewardPointsUsed = (int) (($rewardDiscount / 5) * 100);

                $rewardPointsUsed = min($rewardPointsUsed, $availablePoints);
            }
        }

        // =========================================
        // GCASH PROOF UPLOAD
        // =========================================

        $gcashProof = null;

        if (
            $request->payment_method === 'GCash' &&
            $request->hasFile('gcash_proof')
        ) {
            $gcashProof = $request->file('gcash_proof')
                ->store('gcash-proofs', 'public');
        }

        // =========================================
        // CREATE BOOKING
        // =========================================

        $booking = DB::transaction(function () use (
            $request,
            $selectedAccommodations,
            $totalGuests,
            $numberOfAdults,
            $numberOfKids,
            $gcashProof,
            $accommodationTotal,
            $facilityTotal,
            $poolAdults,
            $poolKids,
            $promoCode,
            $discountAmount,
            $rewardPointsUsed,
            $rewardDiscount,
            $entranceAdultFee,
            $entranceChildFee,
            $swimmingAdultFee,
            $swimmingChildFee
        ) {
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'guest_name' => $request->guest_name,
                'contact_number' => $request->contact_number,

                'number_of_guests' => $totalGuests,
                'number_of_adults' => $numberOfAdults,
                'number_of_kids' => $numberOfKids,

                'check_in' => $request->check_in,
                'check_out' => $request->check_out,

                'payment_method' => $request->payment_method,
                'gcash_reference' => $request->gcash_reference,
                'gcash_proof' => $gcashProof,

                'payment_status' => 'For Verification',

                'accommodation_total' => $accommodationTotal,
                'facility_total' => $facilityTotal,

                // SAVE FEE RATE SNAPSHOTS
                'entrance_adult_rate' => $entranceAdultFee,
                'entrance_child_rate' => $entranceChildFee,
                'swimming_adult_rate' => $swimmingAdultFee,
                'swimming_child_rate' => $swimmingChildFee,

                'pool_adults' => $poolAdults,
                'pool_kids' => $poolKids,

                'status' => 'Pending',

                'promo_code' => $promoCode,
                'discount_amount' => $discountAmount,

                'reward_points_used' => $rewardPointsUsed,
                'reward_discount' => $rewardDiscount,
            ]);

            // Save accommodation prices at booking time
            foreach ($selectedAccommodations as $accommodation) {
                $booking->accommodations()->attach($accommodation->id, [
                    'price_at_booking' => $accommodation->price,
                ]);
            }

            // Deduct reward points and save history
            if ($rewardPointsUsed > 0) {
                $user = auth()->user();

                $user->decrement('reward_points', $rewardPointsUsed);

                \App\Models\RewardPoint::create([
                    'user_id' => $user->id,
                    'booking_id' => $booking->id,
                    'points' => -$rewardPointsUsed,
                    'type' => 'redeemed_checkout',
                    'description' => 'Applied ₱' . number_format($rewardDiscount, 2) . ' discount to Booking #' . $booking->id,
                ]);
            }

            // Release active holds for this user/session
            ReservationHold::where(function ($q) {
                $q->where('user_id', auth()->id())
                    ->orWhere('session_id', request()->session()->getId());
            })
                ->whereNull('released_at')
                ->update(['released_at' => now()]);

            // Auto-log initial GCash payment status
            \App\Models\PaymentLog::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'payment_method' => 'GCash',
                'status' => 'For Verification',
                'reference_number' => $booking->gcash_reference,
                'remarks' => 'Initial GCash payment submitted by customer.',
            ]);

            // Notify admins
            User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
                $admin->notify(new NewBookingNotification($booking));
            });

            return $booking;
        });

        // Broadcast booking and dashboard updates
        \App\Events\BookingCreated::dispatch($booking);
        \App\Events\DashboardStatsUpdated::dispatch();

        // Broadcast availability changes
        foreach ($selectedAccommodations as $acc) {
            $this->availability->notifyChange($acc->id, false);
        }

        return redirect()->route('booking.confirmation', $booking->id);
    }

    // =========================================
    // BOOKING CONFIRMATION
    // =========================================

    public function confirmation($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        // Use relationship query directly to get a Collection.
        // This avoids the accommodations accessor returning a string.
        $accommodations = $booking->accommodations()->get();

        $accommodationBreakdown = [];

        if ($accommodations->isNotEmpty()) {
            foreach ($accommodations as $accommodation) {
                $accommodationBreakdown[] = [
                    'name' => $accommodation->name,
                    'price' => (float) (
                        $accommodation->pivot->price_at_booking
                        ?? $accommodation->price
                    ),
                    'type' => $accommodation->type ?? null,
                ];
            }
        } else {
            $accommodationBreakdown[] = [
                'name' => 'Accommodation',
                'price' => (float) ($booking->accommodation_total ?? 0),
                'type' => null,
            ];
        }

        // =========================================
        // USE SAVED FEE RATES
        // Fallback to current fees for old bookings
        // that have NULL rate snapshots.
        // =========================================

        $currentEntranceAdultFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $currentEntranceChildFee = (float) Fee::active()
            ->ofType('entrance')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        $currentSwimmingAdultFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['adult', 'all'])
            ->sum('amount');

        $currentSwimmingChildFee = (float) Fee::active()
            ->ofType('swimming')
            ->whereIn('applies_to', ['child', 'all'])
            ->sum('amount');

        $entranceAdultFee = (float) (
            $booking->entrance_adult_rate ?? $currentEntranceAdultFee
        );

        $entranceChildFee = (float) (
            $booking->entrance_child_rate ?? $currentEntranceChildFee
        );

        $swimmingAdultFee = (float) (
            $booking->swimming_adult_rate ?? $currentSwimmingAdultFee
        );

        $swimmingChildFee = (float) (
            $booking->swimming_child_rate ?? $currentSwimmingChildFee
        );

        // Calculate entrance and swimming totals using saved rates
        $beachEntranceTotal =
            ((int) $booking->number_of_adults * $entranceAdultFee) +
            ((int) $booking->number_of_kids * $entranceChildFee);

        $poolTotal =
            ((int) $booking->pool_adults * $swimmingAdultFee) +
            ((int) $booking->pool_kids * $swimmingChildFee);

        $subTotal =
            (float) ($booking->accommodation_total ?? 0) +
            (float) ($booking->facility_total ?? 0);

        $grandTotal =
            $subTotal -
            (float) ($booking->discount_amount ?? 0) -
            (float) ($booking->reward_discount ?? 0);

        return view('booking-confirmation', compact(
            'booking',
            'accommodationBreakdown',
            'entranceAdultFee',
            'entranceChildFee',
            'swimmingAdultFee',
            'swimmingChildFee',
            'beachEntranceTotal',
            'poolTotal',
            'grandTotal'
        ));
    }

    // =========================================
    // ELECTRONIC RECEIPT
    // =========================================

    public function receipt($bookingId)
    {
        $booking = Booking::with('accommodations')
            ->where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'Confirmed') {
            return back()->with(
                'error',
                'Electronic receipt is only available for confirmed bookings.'
            );
        }

        if (!$booking->receipt_number) {
            $booking->update([
                'receipt_number' => 'ER-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'receipt_generated_at' => now(),
            ]);

            $booking->refresh();
        }

        $pdf = Pdf::loadView('customer.receipt-pdf', compact('booking'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Receipt-' . $booking->receipt_number . '.pdf');
    }

    // =========================================
    // INVOICE
    // =========================================

    public function invoice($bookingId)
    {
        $booking = Booking::with('accommodations')
            ->where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.invoice-pdf', compact('booking'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'Invoice-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf'
        );
    }

    // =========================================
    // CHECK PROMO
    // =========================================

    public function checkPromo(Request $request)
    {
        $code = strtoupper(trim($request->query('code')));

        $promo = \App\Models\Promotion::where('code', $code)
            ->where('is_active', true)
            ->where('valid_until', '>=', now()->toDateString())
            ->first();

        if ($promo) {
            return response()->json([
                'valid' => true,
                'discount' => $promo->discount_percentage,
            ]);
        }

        return response()->json(['valid' => false]);
    }

    // =========================================
    // REQUEST CANCELLATION
    // =========================================

    public function requestCancellation(Request $request, $bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'Confirmed') {
            return back()->with(
                'error',
                'Only confirmed bookings can request cancellation.'
            );
        }

        if ($booking->cancellation_status === 'Pending') {
            return back()->with(
                'error',
                'A cancellation request is already pending.'
            );
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status' => 'Pending Cancellation',
                'cancellation_requested_at' => now(),
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_status' => 'Pending',
            ]);

            User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
                $admin->notify(
                    new CancellationRequestedNotification($booking)
                );
            });
        });

        return back()->with(
            'success',
            'Your cancellation request has been submitted.'
        );
    }
}