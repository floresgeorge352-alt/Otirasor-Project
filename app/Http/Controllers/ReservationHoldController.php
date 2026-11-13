<?php

namespace App\Http\Controllers;

use App\Events\AvailabilityUpdated;
use App\Models\ReservationHold;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;

class ReservationHoldController extends Controller
{
    public function __construct(private AvailabilityService $availability) {}

    public function store(Request $request)
    {
        $request->validate([
            'accommodation_ids' => 'required|array|min:1',
            'accommodation_ids.*' => 'integer|exists:accommodations,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ]);

        $ids = $request->accommodation_ids;
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;

        if ($this->availability->hasConflict($ids, $checkIn, $checkOut)) {
            return response()->json([
                'ok' => false,
                'message' => 'One or more accommodations are no longer available for those dates.',
            ], 409);
        }

        // I-release ang lumang active holds ng user/session na ito bago mag-create ng bago
        ReservationHold::where(function ($q) use ($request) {
            $q->where('user_id', auth()->id())
              ->orWhere('session_id', $request->session()->getId());
        })->whereNull('released_at')->update(['released_at' => now()]);

        $hold = ReservationHold::create([
            'user_id' => auth()->id(),
            'session_id' => $request->session()->getId(),
            'accommodation_ids' => $ids,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'expires_at' => now()->addMinutes(ReservationHold::holdDurationMinutes()),
        ]);

        AvailabilityUpdated::dispatch([
            'reason' => 'hold_created',
            'hold_id' => $hold->id,
            'accommodation_ids' => $ids,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
        ]);

        return response()->json([
            'ok' => true,
            'hold_id' => $hold->id,
            'expires_at' => $hold->expires_at->toIso8601String(),
            'hold_minutes' => ReservationHold::holdDurationMinutes(),
        ]);
    }

    public function release(Request $request, ReservationHold $hold)
    {
        abort_unless(
            $hold->user_id === auth()->id()
            || $hold->session_id === $request->session()->getId(),
            403
        );

        if ($hold->isActive()) {
            $hold->update(['released_at' => now()]);

            AvailabilityUpdated::dispatch([
                'reason' => 'hold_released',
                'hold_id' => $hold->id,
                'accommodation_ids' => $hold->accommodation_ids,
                'check_in' => $hold->check_in->toDateString(),
                'check_out' => $hold->check_out->toDateString(),
            ]);
        }

        return response()->json(['ok' => true]);
    }
}