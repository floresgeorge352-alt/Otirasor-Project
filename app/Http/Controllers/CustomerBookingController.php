<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingCancelledNotification;
use App\Notifications\NewBookingNotification;

class CustomerBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

        return view(
            'customer.bookings',
            compact('bookings')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | OLD DIRECT CANCELLATION
    |--------------------------------------------------------------------------
    */

    public function cancel(Booking $booking)
    {
        // Siguraduhin na sariling booking lang
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Pending at Confirmed lang
        if (!in_array($booking->status, [
            'Pending',
            'Confirmed'
        ])) {
            return back()->with(
                'error',
                'This booking can no longer be cancelled.'
            );
        }

        $booking->update([
            'status' => 'Cancelled',
        ]);

        // Notify admins
        User::where(
            'role',
            'admin'
        )
        ->get()
        ->each(
            function ($admin) use ($booking) {

                $admin->notify(
                    new BookingCancelledNotification(
                        $booking
                    )
                );

            }
        );

        return back()->with(
            'success',
            'Booking cancelled successfully.'
        );
    }
}