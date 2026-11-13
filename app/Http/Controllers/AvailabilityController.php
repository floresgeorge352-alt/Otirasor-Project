<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function __construct(private AvailabilityService $availability) {}

    public function index(Request $request)
    {
        $request->validate([
            'check_in' => 'nullable|date',
            'check_out' => 'nullable|date|after:check_in',
        ]);

        $checkIn = $request->query('check_in');
        $checkOut = $request->query('check_out');

        $accommodations = Accommodation::orderBy('type')->orderBy('name')->get();

        if ($checkIn && $checkOut) {
            $map = $this->availability->map($checkIn, $checkOut, $accommodations);
        } else {
            $map = [];
            foreach ($accommodations as $accommodation) {
                $map[$accommodation->id] = [
                    'available' => $accommodation->status === 'available',
                    'status' => $accommodation->status,
                    'blocked_by_reservation' => false,
                ];
            }
        }

        $rooms = [];
        foreach ($accommodations as $accommodation) {
            $info = $map[$accommodation->id] ?? null;
            if (! $info) {
                continue;
            }

            $rooms[] = [
                'id' => $accommodation->id,
                'name' => $accommodation->name,
                'type' => $accommodation->type,
                'capacity' => $accommodation->capacity,
                'price' => (float) $accommodation->price,
                'image' => $accommodation->image,
                'available' => $info['available'],
                'status' => $info['status'],
                'blocked_by_reservation' => $info['blocked_by_reservation'],
            ];
        }

        return response()->json([
            'ok' => true,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'hash' => $checkIn && $checkOut
                ? $this->availability->hash($checkIn, $checkOut)
                : md5(json_encode($map)),
            'rooms' => $rooms,
            'generated_at' => now()->toIso8601String(),
        ]);
    }
}