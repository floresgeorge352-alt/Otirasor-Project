<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\Accommodation;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $checkIn = $request->query('check_in', '');
        $checkOut = $request->query('check_out', '');

        if ($checkIn && $checkOut && strtotime($checkOut) <= strtotime($checkIn)) {
            $checkIn = '';
            $checkOut = '';
        }

        $currentCategory = $request->query('category', '');
        $roomType = $request->query('room_type', 'day_use');
        $search = trim($request->query('search', ''));
        $capacity = $request->query('capacity', '');

        $query = Accommodation::query()->orderBy('type')->orderBy('name');

        if ($currentCategory === 'rooms') {
            $query->where('type', 'Room');
            if ($roomType === 'day_use') $query->where('room_type', 'day_use');
            if ($roomType === 'overnight') $query->where('room_type', 'overnight');
        } elseif ($currentCategory === 'cottages') {
            $query->where('type', 'Cottage');
            if ($capacity !== '') $query->where('capacity', $capacity);
            $query->orderBy('capacity')->orderBy('name');
        } elseif ($currentCategory === 'halls') {
            $query->where('type', 'Function Hall');
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        $databaseAccommodations = $query->paginate(12)->withQueryString();

        $bookedAccommodationIds = [];
        
        if ($checkIn && $checkOut) {
            $bookedAccommodationIds = DB::table('booking_accommodation')
                ->join('bookings', 'bookings.id', '=', 'booking_accommodation.booking_id')
                ->whereIn('bookings.status', ['Pending', 'Confirmed'])
                ->where(function($q) use ($checkIn, $checkOut) {
                    $q->where('bookings.check_in', '<', $checkOut)
                      ->where('bookings.check_out', '>', $checkIn);
                })
                ->pluck('booking_accommodation.accommodation_id')
                ->unique()
                ->toArray();
        }

        $accommodations = $databaseAccommodations->through(
            function ($accommodation) use ($bookedAccommodationIds) {
                if ($accommodation->status !== 'available') {
                    $available = false;
                } else {
                    $available = !in_array($accommodation->id, $bookedAccommodationIds);
                }

                return [
                    'id' => $accommodation->id,
                    'name' => $accommodation->name,
                    'description' => $accommodation->description,
                    'amenities' => $accommodation->amenities, // <-- Idinagdag
                    'price' => $accommodation->price,
                    'capacity' => $accommodation->capacity,
                    'type' => $accommodation->type,
                    'image' => $accommodation->image,
                    'available' => $available,
                    'status' => $accommodation->status,
                ];
            }
        );

        return view('accommodations', compact(
            'accommodations',
            'checkIn',
            'checkOut'
        ));
    }
}