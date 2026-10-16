<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $checkIn = $request->query(
            'check_in',
            ''
        );

        $checkOut = $request->query(
            'check_out',
            ''
        );

        $currentCategory = $request->query(
            'category',
            ''
        );

        $roomType = $request->query(
            'room_type',
            'day_use'
        );

        $search = trim(
            $request->query(
                'search',
                ''
            )
        );

        // =====================================================
        // COTTAGE CAPACITY FILTER
        // =====================================================

        $capacity = $request->query(
            'capacity',
            ''
        );


        // =====================================================
        // ACCOMMODATION QUERY
        // =====================================================

        $query = Accommodation::query()
            ->orderBy('type')
            ->orderBy('name');


        // =====================================================
        // CATEGORY FILTER
        // =====================================================

        if ($currentCategory === 'rooms') {

            $query->where(
                'type',
                'Room'
            );


            // -------------------------------------------------
            // DAY USE ROOMS
            // -------------------------------------------------

            if ($roomType === 'day_use') {

                $query->where(
                    'name',
                    'like',
                    '%- Day Use'
                );

            }


            // -------------------------------------------------
            // OVERNIGHT ROOMS
            // -------------------------------------------------

            if ($roomType === 'overnight') {

                $query->where(
                    'name',
                    'like',
                    '%- Overnight'
                );

            }

        }


        // =====================================================
        // COTTAGES
        // =====================================================

        elseif ($currentCategory === 'cottages') {

            $query->where(
                'type',
                'Cottage'
            );


            // -------------------------------------------------
            // FILTER BY CAPACITY
            // Example:
            // 15 Persons
            // 20 Persons
            // -------------------------------------------------

            if ($capacity !== '') {

                $query->where(
                    'capacity',
                    $capacity
                );

            }


            // -------------------------------------------------
            // SORT COTTAGES BY CAPACITY
            // Smaller capacity first
            // Then sort by cottage name
            // -------------------------------------------------

            $query->orderBy(
                'capacity'
            )
            ->orderBy(
                'name'
            );

        }


        // =====================================================
        // FUNCTION HALLS
        // =====================================================

        elseif ($currentCategory === 'halls') {

            $query->where(
                'type',
                'Function Hall'
            );

        }


        // =====================================================
        // SEARCH
        // =====================================================

        if ($search !== '') {

            $query->where(function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                )
                ->orWhere(
                    'description',
                    'like',
                    '%' . $search . '%'
                );

            });

        }


        // =====================================================
        // PAGINATION
        // =====================================================

        $databaseAccommodations = $query
            ->paginate(12)
            ->withQueryString();


        // =====================================================
        // CHECK AVAILABILITY
        // =====================================================

        $accommodations =
            $databaseAccommodations->through(
                function ($accommodation) use (
                    $checkIn,
                    $checkOut
                ) {

                    $available =
                        $this->isAvailable(
                            $accommodation->name,
                            $checkIn,
                            $checkOut,
                            $accommodation->status
                        );


                    return [

                        'id' =>
                            $accommodation->id,

                        'name' =>
                            $accommodation->name,

                        'description' =>
                            $accommodation->description,

                        'price' =>
                            $accommodation->price,

                        'capacity' =>
                            $accommodation->capacity,

                        'type' =>
                            $accommodation->type,

                        'image' =>
                            $accommodation->image,

                        'available' =>
                            $available,

                    ];

                }
            );


        // =====================================================
        // RETURN VIEW
        // =====================================================

        return view(
            'accommodations',
            compact(
                'accommodations',
                'checkIn',
                'checkOut'
            )
        );
    }


    // =========================================================
    // CHECK ACCOMMODATION AVAILABILITY
    // =========================================================

    private function isAvailable(
        $accommodation,
        $checkIn,
        $checkOut,
        $status
    ) {

        // -----------------------------------------------------
        // MANUALLY UNAVAILABLE
        // -----------------------------------------------------

        if ($status !== 'available') {

            return false;

        }


        // -----------------------------------------------------
        // NO DATES SELECTED
        // -----------------------------------------------------

        if (
            !$checkIn ||
            !$checkOut
        ) {

            return true;

        }


        // -----------------------------------------------------
        // CHECK EXISTING BOOKINGS
        // -----------------------------------------------------

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
                $checkIn,
                $checkOut
            ) {

                $query->where(
                    'check_in',
                    '<',
                    $checkOut
                )
                ->where(
                    'check_out',
                    '>',
                    $checkIn
                );

            }
        )
        ->exists();


        return !$conflict;
    }
}