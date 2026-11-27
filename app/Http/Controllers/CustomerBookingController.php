<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Booking;
use App\Models\User;
use App\Models\RewardPoint;
use App\Models\AuditLog;
use App\Notifications\CancellationRequestedNotification;
use App\Notifications\RefundRequestedNotification;
use Illuminate\Http\Request;

class CustomerBookingController extends Controller
{
    // =========================================================
    // CUSTOMER MY BOOKINGS
    // =========================================================

    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with([
                'accommodations',
                'paymentLogs',
                'review',
            ])
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
        $notification = auth()->user()
            ->notifications()
            ->findOrFail($notification);

        $notification->markAsRead();

        return redirect('/my-bookings');
    }

    // =========================================================
    // MARK ALL NOTIFICATIONS AS READ
    // =========================================================

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    // =========================================================
    // CUSTOMER CANCELLATION REQUEST
    // =========================================================

    public function requestCancellation(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        if ($booking->status !== 'Confirmed') {
            return back()->with(
                'error',
                'Only confirmed bookings can request cancellation.'
            );
        }

        if ($booking->cancellation_status === 'Pending') {
            return back()->with(
                'error',
                'A cancellation request is already pending.'
            );
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        DB::transaction(function () use ($booking, $request) {

            $booking->update([
                'status' => 'Pending Cancellation',
                'cancellation_status' => 'Pending',
                'cancellation_reason' => $request->cancellation_reason,
                'cancellation_requested_at' => now(),
            ]);

            User::where('role', 'admin')->get()->each(
                function ($admin) use ($booking) {
                    $admin->notify(
                        new CancellationRequestedNotification($booking)
                    );
                }
            );
        });

        return back()->with(
            'success',
            'Cancellation request submitted. Please wait for admin approval.'
        );
    }

    // =========================================================
    // CUSTOMER REFUND REQUEST
    // =========================================================

    public function requestRefund(Request $request, Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        // Allow refund requests for eligible booking statuses.
        if (!in_array($booking->status, [
            'Confirmed',
            'Checked Out',
            'Cancelled',
            'Pending Cancellation',
        ])) {
            return back()->with(
                'error',
                'This booking is not eligible for a refund.'
            );
        }

        if ($booking->refund_status === 'Pending') {
            return back()->with(
                'error',
                'You already have a pending refund request.'
            );
        }

        $request->validate([
            'refund_request_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'refund_status' => 'Pending',
            'refund_request_reason' => $request->refund_request_reason,
        ]);

        User::where('role', 'admin')->get()->each(
            function ($admin) use ($booking) {
                $admin->notify(
                    new RefundRequestedNotification($booking)
                );
            }
        );

        return back()->with(
            'success',
            'Your refund request has been submitted. Please wait for admin approval.'
        );
    }

    // =========================================================
    // CUSTOMER RESUBMIT PAYMENT PROOF
    // =========================================================

    public function resubmitPayment(Request $request, Booking $booking)
    {
        // Security: only the owner can resubmit
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        // Only allow when admin has re-opened the payment
        if ($booking->payment_status !== 'For Verification') {
            return back()->with('error', 'This booking is not open for payment resubmission.');
        }

        // Only GCash payments have proof uploads
        if ($booking->payment_method !== 'GCash') {
            return back()->with('error', 'Only GCash payments can resubmit proof.');
        }

        $request->validate([
            'gcash_reference' => 'required|string|max:255',
            'gcash_proof'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $oldValues = [
            'payment_status'  => $booking->payment_status,
            'gcash_reference' => $booking->gcash_reference,
            'gcash_proof'     => $booking->gcash_proof,
        ];

        // NOTE: The old proof file is intentionally NOT deleted anymore,
        // so every previously uploaded proof can still be opened from
        // the Payment History.

        // Store the new proof
        $newProofPath = $request->file('gcash_proof')->store('gcash-proofs', 'public');

        // Update the booking (latest proof)
        $booking->update([
            'gcash_reference' => $request->gcash_reference,
            'gcash_proof'     => $newProofPath,
        ]);

        // Audit log
        AuditLog::create([
            'user_id'    => Auth::id(),
            'action'     => 'customer_resubmit_payment',
            'model_type' => Booking::class,
            'model_id'   => $booking->id,
            'old_values' => $oldValues,
            'new_values' => [
                'gcash_reference' => $request->gcash_reference,
                'gcash_proof'     => $newProofPath,
            ],
            'ip_address' => request()->ip(),
        ]);

        // Payment log (now keeps the proof of this specific submission)
        \App\Models\PaymentLog::create([
            'booking_id'       => $booking->id,
            'user_id'          => Auth::id(),
            'payment_method'   => $booking->payment_method,
            'status'           => 'For Verification',
            'reference_number' => $request->gcash_reference,
            'remarks'          => 'Customer resubmitted payment proof after admin re-opened.',
            'proof_path'       => $newProofPath,
        ]);

        return back()->with('success', 'Payment proof resubmitted! Please wait for admin verification.');
    }
}