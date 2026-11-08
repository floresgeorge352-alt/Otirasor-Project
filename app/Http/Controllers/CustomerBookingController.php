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
    // CANCELLATION
    // =========================================================

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if (!in_array($booking->status, ['Pending', 'Confirmed'])) {
            return back()->with('error', 'This booking can no longer be cancelled.');
        }

        $booking->update(['status' => 'Cancelled']);

        // Ibabalik ang points kung may ginamit
        if ($booking->reward_points_used > 0 && $booking->user) {
            $booking->user->increment('reward_points', $booking->reward_points_used);
            RewardPoint::create([
                'user_id' => $booking->user->id,
                'booking_id' => $booking->id,
                'points' => $booking->reward_points_used,
                'type' => 'refunded_booking_cancelled',
                'description' => 'Returned points from cancelled Booking #' . $booking->id,
            ]);
        }

        User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
            $admin->notify(new BookingCancelledNotification($booking));
        });

        return back()->with('success', 'Booking cancelled successfully.');
    }

    // =========================================================
    // REFUND REQUEST
    // =========================================================

    public function requestRefund(Request $request, Booking $booking)
    {
        // 1. Check kung sa user nga ito
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // 2. Check kung pwedeng i-refund (Dapat Confirmed, Checked Out, o Cancelled)
        if (!in_array($booking->status, ['Confirmed', 'Checked Out', 'Cancelled'])) {
            return back()->with('error', 'This booking is not eligible for a refund.');
        }

        // 3. Check kung may pending request na
        if ($booking->refund_status === 'Pending') {
            return back()->with('error', 'You already have a pending refund request.');
        }

        $request->validate([
            'refund_request_reason' => 'required|string|max:500',
        ]);

        // 4. I-update ang booking
        $booking->update([
            'refund_status' => 'Pending',
            'refund_request_reason' => $request->refund_request_reason,
        ]);

        // 5. Notify Admin (Gamit na ang tamang notification class)
        User::where('role', 'admin')->get()->each(function ($admin) use ($booking) {
            $admin->notify(new RefundRequestedNotification($booking));
        });

        return back()->with('success', 'Your refund request has been submitted. Please wait for admin approval.');
    }
}