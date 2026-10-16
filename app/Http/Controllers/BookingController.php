<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use App\Models\Accommodation;
use App\Notifications\NewBookingNotification;

class BookingController extends Controller
{
    // =========================================================
    // BOOKING FORM
    // =========================================================

    public function create(Request $request)
    {
        $accommodations = $request->query(
            'accommodations',
            ''
        );

        $accommodations = array_filter(
            explode(',', $accommodations)
        );

        $checkIn = $request->query(
            'check_in',
            ''
        );

        $checkOut = $request->query(
            'check_out',
            ''
        );


        // =====================================================
        // GET SELECTED ACCOMMODATIONS WITH PRICES
        // =====================================================

        $selectedAccommodations = Accommodation::whereIn(
            'name',
            $accommodations
        )->get();


        // =====================================================
        // MAKE ACCOMMODATION PRICE BREAKDOWN
        // =====================================================

        $accommodationBreakdown = [];

        foreach (
            $accommodations
            as $selectedName
        ) {

            $accommodation =
                $selectedAccommodations->firstWhere(
                    'name',
                    $selectedName
                );


            if ($accommodation) {

                $accommodationBreakdown[] = [

                    'name' =>
                        $accommodation->name,

                    'price' =>
                        (float) $accommodation->price,

                    'type' =>
                        $accommodation->type ?? null,

                ];

            }
        }


        // =====================================================
        // CALCULATE ACCOMMODATION TOTAL
        // =====================================================

        $accommodationTotal =
            $selectedAccommodations->sum(
                'price'
            );


        // =====================================================
        // RETURN BOOKING FORM
        // =====================================================

        return view(
            'booking',
            compact(
                'accommodations',
                'selectedAccommodations',
                'accommodationBreakdown',
                'accommodationTotal',
                'checkIn',
                'checkOut'
            )
        );
    }


    // =========================================================
    // STORE NEW BOOKING
    // =========================================================

    public function store(Request $request)
    {
        $request->validate([

            'guest_name' =>
                'required',

            'contact_number' =>
                'required',

            'number_of_adults' =>
                'required|integer|min:1',

            'number_of_kids' =>
                'required|integer|min:0',

            'check_in' =>
                'required|date',

            'check_out' =>
                'required|date|after:check_in',

            'payment_method' =>
                'required|in:Cash,GCash',

            'gcash_reference' =>
                'required_if:payment_method,GCash|digits:13',

            'gcash_proof' =>
                'required_if:payment_method,GCash|image|mimes:jpg,jpeg,png|max:5120',

            'accommodations' =>
                'required|array|min:1',

            // Swimming Pool
            'swimming_pool' =>
                'nullable|boolean',

            'pool_adults' =>
                'nullable|integer|min:0',

            'pool_kids' =>
                'nullable|integer|min:0',

        ]);


        // =====================================================
        // CHECK ACCOMMODATION AVAILABILITY
        // =====================================================

        foreach (
            $request->accommodations
            as $accommodation
        ) {

            $conflict = Booking::whereIn(
                'status',
                [
                    'Pending',
                    'Confirmed'
                ]
            )
            ->where(
                function ($query) use (
                    $accommodation
                ) {

                    $query->whereRaw(
                        "FIND_IN_SET(
                            ?,
                            REPLACE(
                                accommodations,
                                ', ',
                                ','
                            )
                        )",
                        [
                            $accommodation
                        ]
                    );

                }
            )
            ->where(
                function ($query) use (
                    $request
                ) {

                    $query->where(
                        'check_in',
                        '<',
                        $request->check_out
                    )
                    ->where(
                        'check_out',
                        '>',
                        $request->check_in
                    );

                }
            )
            ->exists();


            if ($conflict) {

                return back()
                    ->withInput()
                    ->with(
                        'error',
                        $accommodation .
                        ' is already booked for the selected dates.'
                    );

            }
        }


        // =====================================================
        // CALCULATE TOTAL GUESTS
        // =====================================================

        $totalGuests =
            (int) $request->number_of_adults +
            (int) $request->number_of_kids;


        // =====================================================
        // GET SELECTED ACCOMMODATIONS WITH PRICES
        // =====================================================

        $selectedAccommodations = Accommodation::whereIn(
            'name',
            $request->accommodations
        )
        ->get();


        // =====================================================
        // MAKE ACCOMMODATION PRICE BREAKDOWN
        // =====================================================

        $accommodationBreakdown = [];

        foreach (
            $request->accommodations
            as $selectedName
        ) {

            $accommodation =
                $selectedAccommodations->firstWhere(
                    'name',
                    $selectedName
                );


            if ($accommodation) {

                $accommodationBreakdown[] = [

                    'name' =>
                        $accommodation->name,

                    'price' =>
                        (float) $accommodation->price,

                    'type' =>
                        $accommodation->type ?? null,

                ];

            }

        }


        // =====================================================
        // CALCULATE ACCOMMODATION TOTAL
        // =====================================================

        $accommodationTotal =
            $selectedAccommodations->sum(
                'price'
            );


        // =====================================================
        // CALCULATE BEACH / SWIMMING POOL TOTAL
        // =====================================================

        $numberOfAdults =
            (int) $request->number_of_adults;

        $numberOfKids =
            (int) $request->number_of_kids;


        // =====================================================
        // BEACH ENTRANCE
        //
        // Entrance is AUTOMATIC.
        //
        // Adult = ₱20
        // Kids  = ₱10
        // =====================================================

        $beachEntranceTotal =
            ($numberOfAdults * 20) +
            ($numberOfKids * 10);


        // =====================================================
        // SWIMMING POOL
        //
        // Pool is OPTIONAL.
        //
        // Adult swimmer = ₱70
        // Kid swimmer   = ₱50
        //
        // Only the guests who will swim are charged.
        // =====================================================

        $poolAdults = (int) (
            $request->pool_adults ?? 0
        );

        $poolKids = (int) (
            $request->pool_kids ?? 0
        );


        // =====================================================
        // IF POOL IS NOT SELECTED
        // RESET SWIMMING COUNTS TO ZERO
        // =====================================================

        if (
            !$request->boolean('swimming_pool')
        ) {

            $poolAdults = 0;
            $poolKids = 0;

        }


        // =====================================================
        // PREVENT POOL COUNTS FROM EXCEEDING GUEST COUNTS
        // =====================================================

        if (
            $poolAdults > $numberOfAdults
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'The number of adult swimmers cannot exceed the number of adult guests.'
                );

        }


        if (
            $poolKids > $numberOfKids
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'The number of kid swimmers cannot exceed the number of kid guests.'
                );

        }


        // =====================================================
        // CALCULATE POOL TOTAL
        // =====================================================

        $poolTotal =
            ($poolAdults * 70) +
            ($poolKids * 50);


        // =====================================================
        // COMBINED FACILITY TOTAL
        //
        // Entrance + Pool
        // =====================================================

        $facilityTotal =
            $beachEntranceTotal +
            $poolTotal;


        // =====================================================
        // UPLOAD GCASH PROOF
        // =====================================================

        $gcashProof = null;


        if (
            $request->payment_method === 'GCash' &&
            $request->hasFile('gcash_proof')
        ) {

            $gcashProof =
                $request->file('gcash_proof')
                    ->store(
                        'gcash-proofs',
                        'public'
                    );

        }


        // =====================================================
        // CREATE BOOKING
        // =====================================================

        $booking = Booking::create([

            'user_id' =>
                auth()->id(),

            'guest_name' =>
                $request->guest_name,

            'contact_number' =>
                $request->contact_number,

            'number_of_guests' =>
                $totalGuests,

            'number_of_adults' =>
                $numberOfAdults,

            'number_of_kids' =>
                $numberOfKids,

            'check_in' =>
                $request->check_in,

            'check_out' =>
                $request->check_out,

            'payment_method' =>
                $request->payment_method,

            'gcash_reference' =>
                $request->gcash_reference,

            'gcash_proof' =>
                $gcashProof,

            'payment_status' =>
                $request->payment_method === 'GCash'
                    ? 'For Verification'
                    : 'Not Applicable',

            'accommodations' =>
                implode(
                    ', ',
                    $request->accommodations
                ),

            'accommodation_total' =>
                $accommodationTotal,

            'facility_total' =>
                $facilityTotal,

            // Swimming Pool Guest Counts
            'pool_adults' =>
                $poolAdults,

            'pool_kids' =>
                $poolKids,

            'status' =>
                'Pending',

        ]);


        // =====================================================
        // SEND NOTIFICATION TO ADMINS
        // =====================================================

        User::where(
            'role',
            'admin'
        )
        ->get()
        ->each(
            function ($admin) use ($booking) {

                $admin->notify(
                    new NewBookingNotification(
                        $booking
                    )
                );

            }
        );


        // =====================================================
        // BOOKING CONFIRMATION PAGE
        // =====================================================

        return view(
            'booking-confirmation',
            compact(
                'booking',
                'accommodationBreakdown',
                'beachEntranceTotal',
                'poolTotal'
            )
        );
    }


    // =========================================================
    // ELECTRONIC RECEIPT
    // =========================================================

    public function receipt($bookingId)
    {
        $booking = Booking::where(
            'id',
            $bookingId
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->firstOrFail();


        // -----------------------------------------------------
        // RECEIPT ONLY AVAILABLE FOR CONFIRMED BOOKINGS
        // -----------------------------------------------------

        if (
            $booking->status !== 'Confirmed'
        ) {

            return back()->with(
                'error',
                'Electronic receipt is only available for confirmed bookings.'
            );

        }


        // -----------------------------------------------------
        // MAKE SURE RECEIPT EXISTS
        // -----------------------------------------------------

        if (
            !$booking->receipt_number
        ) {

            $booking->update([

                'receipt_number' =>
                    'ER-' . str_pad(
                        $booking->id,
                        5,
                        '0',
                        STR_PAD_LEFT
                    ),

                'receipt_generated_at' =>
                    now(),

            ]);

        }


        return view(
            'customer.receipt',
            compact('booking')
        );
    }


    // =========================================================
    // CUSTOMER REQUEST CANCELLATION
    // =========================================================

    public function requestCancellation(
        Request $request,
        $bookingId
    ) {

        $booking = Booking::where(
            'id',
            $bookingId
        )
        ->where(
            'user_id',
            auth()->id()
        )
        ->firstOrFail();


        // -----------------------------------------------------
        // ONLY CONFIRMED BOOKINGS CAN REQUEST CANCELLATION
        // -----------------------------------------------------

        if (
            $booking->status !== 'Confirmed'
        ) {

            return back()->with(
                'error',
                'Only confirmed bookings can request cancellation.'
            );

        }


        // -----------------------------------------------------
        // PREVENT DUPLICATE REQUEST
        // -----------------------------------------------------

        if (
            $booking->cancellation_status === 'Pending'
        ) {

            return back()->with(
                'error',
                'A cancellation request is already pending.'
            );

        }


        // -----------------------------------------------------
        // VALIDATE REASON
        // -----------------------------------------------------

        $request->validate([

            'cancellation_reason' =>
                'required|string|max:500',

        ]);


        // -----------------------------------------------------
        // SAVE CANCELLATION REQUEST
        // -----------------------------------------------------

        $booking->update([

            'cancellation_requested_at' =>
                now(),

            'cancellation_reason' =>
                $request->cancellation_reason,

            'cancellation_status' =>
                'Pending',

        ]);


        // -----------------------------------------------------
        // NOTIFY ADMINS
        // -----------------------------------------------------

        User::where(
            'role',
            'admin'
        )
        ->get()
        ->each(
            function ($admin) use ($booking) {

                $admin->notify(
                    new NewBookingNotification(
                        $booking
                    )
                );

            }
        );


        return back()->with(
            'success',
            'Your cancellation request has been submitted.'
        );
    }


    // =========================================================
    // ADMIN APPROVE CANCELLATION
    // =========================================================

    public function approveCancellation(
        $bookingId
    ) {

        $booking = Booking::findOrFail(
            $bookingId
        );


        // -----------------------------------------------------
        // ONLY PENDING CANCELLATION REQUEST
        // -----------------------------------------------------

        if (
            $booking->cancellation_status !== 'Pending'
        ) {

            return back()->with(
                'error',
                'There is no pending cancellation request.'
            );

        }


        // -----------------------------------------------------
        // CANCEL BOOKING
        // -----------------------------------------------------

        $booking->update([

            'status' =>
                'Cancelled',

            'cancellation_status' =>
                'Approved',

        ]);


        return back()->with(
            'success',
            'Cancellation request approved.'
        );
    }


    // =========================================================
    // ADMIN REJECT CANCELLATION
    // =========================================================

    public function rejectCancellation(
        $bookingId
    ) {

        $booking = Booking::findOrFail(
            $bookingId
        );


        // -----------------------------------------------------
        // ONLY PENDING CANCELLATION REQUEST
        // -----------------------------------------------------

        if (
            $booking->cancellation_status !== 'Pending'
        ) {

            return back()->with(
                'error',
                'There is no pending cancellation request.'
            );

        }


        // -----------------------------------------------------
        // REJECT REQUEST
        // BOOKING REMAINS CONFIRMED
        // -----------------------------------------------------

        $booking->update([

            'cancellation_status' =>
                'Rejected',

        ]);


        return back()->with(
            'success',
            'Cancellation request rejected. The booking remains confirmed.'
        );
    }
}