<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\User;
use App\Models\Accommodation;
use App\Notifications\NewBookingNotification;
use App\Notifications\CancellationRequestedNotification;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
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
        
        $userRewardPoints = auth()->check() ? (auth()->user()->reward_points ?? 0) : 0;

        return view('booking', compact(
            'accommodations',
            'selectedAccommodations',
            'accommodationBreakdown',
            'accommodationTotal',
            'checkIn',
            'checkOut',
            'userRewardPoints'
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
            'payment_method' => 'required|in:Cash,GCash',
            'gcash_reference' => 'nullable|required_if:payment_method,GCash|digits:13',
            'gcash_proof' => 'nullable|required_if:payment_method,GCash|image|mimes:jpg,jpeg,png|max:5120',
            'accommodations' => 'required|array|min:1',
            'swimming_pool' => 'nullable|boolean',
            'pool_adults' => 'nullable|integer|min:0',
            'pool_kids' => 'nullable|integer|min:0',
            'promo_code' => 'nullable|string|max:50',
            'use_rewards' => 'nullable|boolean',
        ]);

        $selectedAccommodations = Accommodation::whereIn('name', $request->accommodations)->get();

        $conflict = Booking::whereIn('status', ['Pending', 'Confirmed'])
            ->where('check_in', '<', $request->check_out)
            ->where('check_out', '>', $request->check_in)
            ->whereHas('accommodations', function ($query) use ($selectedAccommodations) {
                $query->whereIn('accommodation_id', $selectedAccommodations->pluck('id'));
            })
            ->when(auth()->check(), function ($q) {
                return $q->where('user_id', '!=', auth()->id());
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'One or more of the selected accommodations are already booked for those dates.');
        }

        $totalGuests = (int) $request->number_of_adults + (int) $request->number_of_kids;
        $accommodationTotal = $selectedAccommodations->sum('price');
        $numberOfAdults = (int) $request->number_of_adults;
        $numberOfKids = (int) $request->number_of_kids;

        $beachEntranceTotal = ($numberOfAdults * 20) + ($numberOfKids * 10);
        $poolAdults = (int) ($request->pool_adults ?? 0);
        $poolKids = (int) ($request->pool_kids ?? 0);

        if (!$request->boolean('swimming_pool')) {
            $poolAdults = 0;
            $poolKids = 0;
        }

        if ($poolAdults > $numberOfAdults) {
            return back()->withInput()->with('error', 'The number of adult swimmers cannot exceed the number of adult guests.');
        }

        if ($poolKids > $numberOfKids) {
            return back()->withInput()->with('error', 'The number of kid swimmers cannot exceed the number of kid guests.');
        }

        $poolTotal = ($poolAdults * 70) + ($poolKids * 50);
        $facilityTotal = $beachEntranceTotal + $poolTotal;

        // --- PROMO CODE LOGIC ---
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
                $discountAmount = ($subtotal * (float) $promo->discount_percentage) / 100;
            }
        }

        // --- REWARDS LOGIC ---
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

        $gcashProof = null;
        if ($request->payment_method === 'GCash' && $request->hasFile('gcash_proof')) {
            $gcashProof = $request->file('gcash_proof')->store('gcash-proofs', 'public');
        }

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
            $rewardDiscount
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
                'payment_status' => $request->payment_method === 'GCash' ? 'For Verification' : 'Not Applicable',
                'accommodation_total' => $accommodationTotal,
                'facility_total' => $facilityTotal,
                'pool_adults' => $poolAdults,
                'pool_kids' => $poolKids,
                'status' => 'Pending',
                'promo_code' => $promoCode,
                'discount_amount' => $discountAmount,
                'reward_points_used' => $rewardPointsUsed,
                'reward_discount' => $rewardDiscount,
            ]);

            foreach ($selectedAccommodations as $accommodation) {
                $booking->accommodations()->attach($accommodation->id, [
                    'price_at_booking' => $accommodation->price,
                ]);
            }

            // Deduct points at log sa history
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

            User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
                $admin->notify(new NewBookingNotification($booking));
            });

            return $booking;
        });

        \App\Events\BookingCreated::dispatch($booking);
        \App\Events\DashboardStatsUpdated::dispatch();

        return redirect()->route('booking.confirmation', $booking->id);
    }

    public function confirmation($bookingId)
    {
        $booking = Booking::with('accommodations')->findOrFail($bookingId);

        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $accommodationBreakdown = [];

        if ($booking->accommodations && $booking->accommodations->isNotEmpty()) {
            foreach ($booking->accommodations as $accommodation) {
                $accommodationBreakdown[] = [
                    'name' => $accommodation->name,
                    'price' => (float) $accommodation->price,
                    'type' => $accommodation->type ?? null,
                ];
            }
        } else {
            $accommodationBreakdown[] = [
                'name' => 'Accommodation',
                'price' => $booking->accommodation_total ?? 0,
                'type' => null,
            ];
        }

        $beachEntranceTotal = ($booking->number_of_adults * 20) + ($booking->number_of_kids * 10);
        $poolTotal = ($booking->pool_adults * 70) + ($booking->pool_kids * 50);

        $subTotal = ($booking->accommodation_total ?? 0) + ($booking->facility_total ?? 0);
        $grandTotal = $subTotal - ($booking->discount_amount ?? 0) - ($booking->reward_discount ?? 0);

        return view('booking-confirmation', compact(
            'booking',
            'accommodationBreakdown',
            'beachEntranceTotal',
            'poolTotal',
            'grandTotal'
        ));
    }

    public function receipt($bookingId)
    {
        $booking = Booking::with('accommodations')
            ->where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Electronic receipt is only available for confirmed bookings.');
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

    public function invoice($bookingId)
    {
        $booking = Booking::with('accommodations')
            ->where('id', $bookingId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $pdf = Pdf::loadView('customer.invoice-pdf', compact('booking'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT) . '.pdf');
    }

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
                'discount' => $promo->discount_percentage
            ]);
        }

        return response()->json(['valid' => false]);
    }

    public function requestCancellation(Request $request, $bookingId)
    {
        $booking = Booking::where('id', $bookingId)->where('user_id', auth()->id())->firstOrFail();

        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed bookings can request cancellation.');
        }

        if ($booking->cancellation_status === 'Pending') {
            return back()->with('error', 'A cancellation request is already pending.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'cancellation_requested_at' => now(),
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_status' => 'Pending',
            ]);

            User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
                $admin->notify(new CancellationRequestedNotification($booking));
            });
        });

        return back()->with('success', 'Your cancellation request has been submitted.');
    }
}