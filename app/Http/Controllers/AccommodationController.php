<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class AccommodationController extends Controller
{
    public function __construct(private AvailabilityService $availability) {}

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

        // Build availability map via service (booked + held + status)
        $availabilityMap = [];

        if ($checkIn && $checkOut) {
            $availabilityMap = $this->availability->map(
                $checkIn,
                $checkOut,
                $databaseAccommodations->getCollection()
            );
        }

        $accommodations = $databaseAccommodations->through(
            function ($accommodation) use ($availabilityMap) {
                if (! empty($availabilityMap[$accommodation->id])) {
                    $available = $availabilityMap[$accommodation->id]['available'];
                } else {
                    $available = $accommodation->status === 'available';
                }

                return [
                    'id' => $accommodation->id,
                    'name' => $accommodation->name,
                    'description' => $accommodation->description,
                    'amenities' => $accommodation->amenities,
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