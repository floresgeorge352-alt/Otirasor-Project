<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\User;
use App\Models\RewardPoint;
use App\Notifications\BookingCancelledNotification;
use App\Notifications\RefundRequestedNotification;
use Illuminate\Http\Request;

class CustomerBookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->latest()
            ->paginate(5);

        return view('customer.bookings', compact('bookings'));
    }

    // =========================================================
    // CUSTOMER NOTIFICATIONS
    // =========================================================

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->get();
        return view('customer.notifications', compact('notifications'));
    }

    public function openNotification($notification)
    {
        $notification = auth()->user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        return redirect('/my-bookings');
    }

    // =========================================================
    // CANCELLATION REQUEST (HINDI DIRECT CANCEL)
    // =========================================================
    
    public function requestCancellation(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed bookings can request cancellation.');
        }

        if ($booking->cancellation_status === 'Pending') {
            return back()->with('error', 'A cancellation request is already pending.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'Pending Cancellation',
            'cancellation_status' => 'Pending',
            'cancellation_reason' => $request->cancellation_reason,
            'cancellation_requested_at' => now(),
        ]);

        User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
            $admin->notify(new BookingCancelledNotification($booking));
        });

        return back()->with('success', 'Cancellation request submitted. Please wait for admin approval.');
    }

    // =========================================================
    // REFUND REQUEST
    // =========================================================

    public function requestRefund(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Papayagan ang Refund kahit Pending Cancellation
        if (!in_array($booking->status, ['Confirmed', 'Checked Out', 'Cancelled', 'Pending Cancellation'])) {
            return back()->with('error', 'This booking is not eligible for a refund.');
        }

        if ($booking->refund_status === 'Pending') {
            return back()->with('error', 'You already have a pending refund request.');
        }

        $request->validate([
            'refund_request_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'refund_status' => 'Pending',
            'refund_request_reason' => $request->refund_request_reason,
        ]);

        User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
            $admin->notify(new RefundRequestedNotification($booking));
        });

        return back()->with('success', 'Your refund request has been submitted. Please wait for admin approval.');
    }
}