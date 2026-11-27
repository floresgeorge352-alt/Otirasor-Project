<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\RewardPoint;
use App\Models\AuditLog;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\BookingRejectedNotification;
use App\Notifications\CancellationApprovedNotification;
use App\Notifications\CancellationRejectedNotification;
use App\Notifications\PaymentVerifiedNotification;
use App\Notifications\PaymentRejectedNotification;
use App\Notifications\PaymentReopenedNotification;
use App\Notifications\RefundApprovedNotification;
use App\Notifications\RefundRejectedNotification;
use App\Mail\ReservationApproved;
use App\Mail\ReservationRejected;
use App\Mail\PaymentRejected;
use App\Mail\PaymentReopened;
use App\Mail\RefundProcessedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminBookingController extends Controller
{
    private function broadcastAvailability(Booking $booking, string $reason): void
    {
        \App\Events\AvailabilityUpdated::dispatch([
            'reason' => $reason,
            'booking_id' => $booking->id,
            'status' => $booking->status,
        ]);

        $available = in_array($booking->status, ['Completed', 'Cancelled', 'Rejected', 'No Show'], true)
            || $booking->refund_status === 'Refunded';

        app(\App\Services\AvailabilityService::class)->notifyBooking($booking, $available);
    }

    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $month = $request->query('month');
        $bookingId = $request->query('booking_id');

        $query = Booking::query()->with('paymentLogs');

        if ($bookingId) {
            $query->where('id', $bookingId);
        } elseif ($month) {
            $query->whereMonth('created_at', $month)->whereYear('created_at', date('Y'));
            $filter = 'monthly';
        } elseif ($filter === 'pending') {
            $query->where('status', 'Pending');
        } elseif ($filter === 'confirmed') {
            $query->where('status', 'Confirmed');
        } elseif ($filter === 'checked_in') {
            $query->where('status', 'Checked In');
        } elseif ($filter === 'checked_out') {
            $query->where('status', 'Checked Out');
        } elseif ($filter === 'completed') {
            $query->where('status', 'Completed');
        } elseif ($filter === 'rejected') {
            $query->where('status', 'Rejected');
        } elseif ($filter === 'cancelled') {
            $query->where('status', 'Cancelled');
        } elseif ($filter === 'refund_pending') {
            $query->where('refund_status', 'Pending');
        }

        $bookings = $query->latest()->get();

        return view('admin.bookings', compact('bookings', 'filter', 'month'));
    }

    public function approve(Request $request, Booking $booking)
    {
        if ($booking->payment_method === 'GCash' && $booking->payment_status !== 'Verified') {
            $msg = 'Verify the GCash payment before approving this booking.';
            return $request->wantsJson()
                ? response()->json(['error' => $msg], 400)
                : back()->with('error', $msg);
        }

        $oldStatus = $booking->status;

        DB::transaction(function () use ($booking, $oldStatus) {
            $booking->update([
                'status' => 'Confirmed',
                'receipt_number' => 'ER-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'receipt_generated_at' => now(),
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'approve_booking',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => ['status' => $oldStatus],
                'new_values' => ['status' => 'Confirmed'],
                'ip_address' => request()->ip(),
            ]);

            \App\Models\PaymentLog::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'payment_method' => $booking->payment_method,
                'status' => 'Receipt Generated',
                'reference_number' => $booking->gcash_reference,
                'remarks' => 'Booking approved and receipt automatically generated.',
            ]);

            if ($booking->user) {
                $booking->user->notify(new BookingConfirmedNotification($booking));
            }

            $booking->load('user');

            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new ReservationApproved($booking));
            }

            \App\Events\BookingStatusUpdated::dispatch($booking);
            \App\Events\RoomStatusUpdated::dispatch($booking);
        });

        $this->broadcastAvailability($booking, 'admin_approved');

        $msg = 'Booking approved successfully and e-receipt generated.';

        return $request->wantsJson()
            ? response()->json(['success' => $msg])
            : redirect('/admin/bookings?filter=confirmed')->with('success', $msg);
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $oldStatus = $booking->status;

        DB::transaction(function () use ($booking, $request, $oldStatus) {
            $booking->update([
                'status' => 'Rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject_booking',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => ['status' => $oldStatus],
                'new_values' => [
                    'status' => 'Rejected',
                    'reason' => $request->rejection_reason,
                ],
                'ip_address' => request()->ip(),
            ]);

            if ($booking->reward_points_used > 0 && $booking->user) {
                $booking->user->increment('reward_points', $booking->reward_points_used);

                RewardPoint::create([
                    'user_id' => $booking->user->id,
                    'booking_id' => $booking->id,
                    'points' => $booking->reward_points_used,
                    'type' => 'refunded_booking_rejected',
                    'description' => 'Returned points from rejected Booking #' . $booking->id,
                ]);
            }

            if ($booking->user) {
                $booking->user->notify(new BookingRejectedNotification($booking));
            }

            $booking->load('user');

            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new ReservationRejected($booking));
            }

            \App\Events\BookingStatusUpdated::dispatch($booking);
            \App\Events\RoomStatusUpdated::dispatch($booking);
        });

        $this->broadcastAvailability($booking, 'admin_rejected');

        $msg = 'Booking rejected successfully and email sent.';

        return $request->wantsJson()
            ? response()->json(['success' => $msg])
            : redirect('/admin/bookings?filter=rejected')->with('success', $msg);
    }

    public function verifyPayment(Request $request, Booking $booking)
    {
        $oldPaymentStatus = $booking->payment_status;

        DB::transaction(function () use ($booking, $oldPaymentStatus) {
            $booking->update([
                'payment_status' => 'Verified',
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'verify_payment',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => ['payment_status' => $oldPaymentStatus],
                'new_values' => ['payment_status' => 'Verified'],
                'ip_address' => request()->ip(),
            ]);

            \App\Models\PaymentLog::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'payment_method' => $booking->payment_method,
                'status' => 'Verified',
                'reference_number' => $booking->gcash_reference,
                'remarks' => 'Payment verified by admin.',
            ]);

            if ($booking->user) {
                $booking->user->notify(new PaymentVerifiedNotification($booking));
            }

            $booking->load('user');

            if ($booking->user && $booking->user->email) {
                try {
                    Mail::to($booking->user->email)->send(new \App\Mail\BookingReceiptMail($booking));
                } catch (\Exception $e) {
                    \Log::error('Receipt email failed to send: ' . $e->getMessage());
                }
            }
        });

        $msg = 'GCash payment verified successfully.';

        return $request->wantsJson()
            ? response()->json(['success' => $msg])
            : redirect('/admin/bookings')->with('success', $msg);
    }

    public function rejectPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_rejection_reason' => 'required|string|max:1000',
        ]);

        $oldPaymentStatus = $booking->payment_status;
        $oldRefundStatus = $booking->refund_status;

        DB::transaction(function () use ($booking, $request, $oldPaymentStatus, $oldRefundStatus) {
            $newRefundStatus = $booking->status === 'Confirmed'
                ? 'Pending'
                : $oldRefundStatus;

            $booking->update([
                'payment_status' => 'Rejected',
                'payment_rejection_reason' => $request->payment_rejection_reason,
                'refund_status' => $newRefundStatus,
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject_payment',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => [
                    'payment_status' => $oldPaymentStatus,
                    'refund_status' => $oldRefundStatus,
                ],
                'new_values' => [
                    'payment_status' => 'Rejected',
                    'refund_status' => $newRefundStatus,
                    'reason' => $request->payment_rejection_reason,
                ],
                'ip_address' => request()->ip(),
            ]);

            \App\Models\PaymentLog::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'payment_method' => $booking->payment_method,
                'status' => 'Rejected',
                'reference_number' => $booking->gcash_reference,
                'remarks' => $request->payment_rejection_reason,
            ]);

            if ($booking->user) {
                $booking->user->notify(new PaymentRejectedNotification($booking));
            }

            $booking->load('user');

            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new PaymentRejected($booking));
            }
        });

        $msg = 'GCash payment rejected and email sent.';

        return $request->wantsJson()
            ? response()->json(['success' => $msg])
            : redirect('/admin/bookings')->with('success', $msg);
    }

    public function reopenPayment(Request $request, Booking $booking)
    {
        if ($booking->payment_status !== 'Rejected') {
            return back()->with('error', 'Only rejected payments can be re-opened.');
        }

        $oldPaymentStatus = $booking->payment_status;

        DB::transaction(function () use ($booking, $oldPaymentStatus) {
            $booking->update([
                'payment_status' => 'For Verification',
                'payment_rejection_reason' => null, // Clear the reason
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reopen_payment',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => ['payment_status' => $oldPaymentStatus],
                'new_values' => ['payment_status' => 'For Verification'],
                'ip_address' => request()->ip(),
            ]);

            \App\Models\PaymentLog::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'payment_method' => $booking->payment_method,
                'status' => 'For Verification',
                'reference_number' => $booking->gcash_reference,
                'remarks' => 'Payment re-opened by admin for re-verification.',
            ]);

            // Send notification to customer (database & email)
            if ($booking->user) {
                $booking->user->notify(new PaymentReopenedNotification($booking));
            }

            $booking->load('user');

            if ($booking->user && $booking->user->email) {
                try {
                    Mail::to($booking->user->email)->send(new PaymentReopened($booking));
                } catch (\Exception $e) {
                    Log::error('Payment reopened email failed to send: ' . $e->getMessage());
                }
            }
        });

        return back()->with('success', 'Payment has been re-opened. The customer can now resubmit their proof.');
    }

    public function refund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_notes' => 'nullable|string|max:1000',
        ]);

        $oldValues = [
            'refund_status' => $booking->refund_status,
            'refunded_at' => $booking->refunded_at,
            'refund_notes' => $booking->refund_notes,
        ];

        $booking->update([
            'refund_status' => 'Refunded',
            'refunded_at' => now(),
            'refund_notes' => $request->refund_notes,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'refund_booking',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => $oldValues,
            'new_values' => [
                'refund_status' => $booking->refund_status,
                'refunded_at' => $booking->refunded_at,
                'refund_notes' => $booking->refund_notes,
            ],
            'ip_address' => request()->ip(),
        ]);

        $this->broadcastAvailability($booking, 'admin_refunded');

        return redirect('/admin/bookings')
            ->with('success', 'Booking marked as refunded successfully.');
    }

    public function approveRefund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_reference' => 'required|string|max:255',
            'refund_message' => 'nullable|string|max:1000',
            'refund_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if ($booking->refund_status !== 'Pending') {
            return back()->with('error', 'This refund request is not pending.');
        }

        $oldValues = [
            'refund_status' => $booking->refund_status,
            'refunded_at' => $booking->refunded_at,
            'refund_reference' => $booking->refund_reference,
            'refund_message' => $booking->refund_message,
            'refund_proof' => $booking->refund_proof,
        ];

        $refundProofPath = $booking->refund_proof;

        if ($request->hasFile('refund_proof')) {
            if ($refundProofPath && Storage::disk('public')->exists($refundProofPath)) {
                Storage::disk('public')->delete($refundProofPath);
            }

            $refundProofPath = $request->file('refund_proof')->store('refund-proofs', 'public');
        }

        $booking->update([
            'refund_status' => 'Refunded',
            'refunded_at' => now(),
            'refund_reference' => $request->refund_reference,
            'refund_message' => $request->refund_message,
            'refund_proof' => $refundProofPath,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'approve_refund',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => $oldValues,
            'new_values' => [
                'refund_status' => $booking->refund_status,
                'refunded_at' => $booking->refunded_at,
                'refund_reference' => $booking->refund_reference,
                'refund_message' => $booking->refund_message,
                'refund_proof' => $booking->refund_proof,
            ],
            'ip_address' => request()->ip(),
        ]);

        if ($booking->user) {
            $booking->user->notify(new RefundApprovedNotification($booking));
        }

        $booking->load('user');

        if ($booking->user && $booking->user->email) {
            try {
                Mail::to($booking->user->email)->send(new RefundProcessedMail($booking));
            } catch (\Exception $e) {
                Log::error('Email failed to send: ' . $e->getMessage());
            }
        }

        $this->broadcastAvailability($booking, 'admin_refund_approved');

        return back()->with('success', 'Refund approved, marked as processed, and email sent.');
    }

    public function rejectRefund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_notes' => 'required|string|max:1000',
        ]);

        if ($booking->refund_status !== 'Pending') {
            return back()->with('error', 'This refund request is not pending.');
        }

        $oldValues = [
            'refund_status' => $booking->refund_status,
            'refund_notes' => $booking->refund_notes,
        ];

        $booking->update([
            'refund_status' => 'Rejected',
            'refund_notes' => $request->refund_notes,
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'reject_refund',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => $oldValues,
            'new_values' => [
                'refund_status' => $booking->refund_status,
                'refund_notes' => $booking->refund_notes,
            ],
            'ip_address' => request()->ip(),
        ]);

        if ($booking->user) {
            $booking->user->notify(new RefundRejectedNotification($booking));
        }

        return back()->with('success', 'Refund request rejected.');
    }

    public function approveCancellation(Booking $booking)
    {
        if ($booking->cancellation_status !== 'Pending') {
            return back()->with('error', 'There is no pending cancellation request.');
        }

        $oldValues = [
            'status' => $booking->status,
            'cancellation_status' => $booking->cancellation_status,
        ];

        DB::transaction(function () use ($booking, $oldValues) {
            $booking->update([
                'status' => 'Cancelled',
                'cancellation_status' => 'Approved',
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'approve_cancellation',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => $oldValues,
                'new_values' => [
                    'status' => $booking->status,
                    'cancellation_status' => $booking->cancellation_status,
                ],
                'ip_address' => request()->ip(),
            ]);

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

            if ($booking->user) {
                $booking->user->notify(new CancellationApprovedNotification($booking));
            }

            \App\Events\BookingStatusUpdated::dispatch($booking);
            \App\Events\RoomStatusUpdated::dispatch($booking);
        });

        $this->broadcastAvailability($booking, 'admin_cancellation_approved');

        return back()->with('success', 'Cancellation request approved.');
    }

    public function rejectCancellation(Booking $booking)
    {
        if ($booking->cancellation_status !== 'Pending') {
            return back()->with('error', 'There is no pending cancellation request.');
        }

        $oldValues = [
            'status' => $booking->status,
            'cancellation_status' => $booking->cancellation_status,
        ];

        DB::transaction(function () use ($booking, $oldValues) {
            $booking->update([
                'status' => 'Confirmed',
                'cancellation_status' => 'Rejected',
            ]);

            AuditLog::create([
                'user_id' => auth()->id(),
                'action' => 'reject_cancellation',
                'model_type' => Booking::class,
                'model_id' => $booking->id,
                'old_values' => $oldValues,
                'new_values' => [
                    'status' => $booking->status,
                    'cancellation_status' => $booking->cancellation_status,
                ],
                'ip_address' => request()->ip(),
            ]);

            if ($booking->user) {
                $booking->user->notify(new CancellationRejectedNotification($booking));
            }

            \App\Events\BookingStatusUpdated::dispatch($booking);
            \App\Events\RoomStatusUpdated::dispatch($booking);
        });

        return back()->with('success', 'Cancellation request rejected. The booking remains confirmed.');
    }

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        $oldStatus = $booking->status;

        $booking->update([
            'status' => 'Checked In',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'check_in',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $booking->status],
            'ip_address' => request()->ip(),
        ]);

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        $this->broadcastAvailability($booking, 'admin_checked_in');

        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'Checked In') {
            return back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        $oldStatus = $booking->status;

        $booking->update([
            'status' => 'Checked Out',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'check_out',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $booking->status],
            'ip_address' => request()->ip(),
        ]);

        $rooms = $booking->accommodations()->get();

        if ($rooms->isNotEmpty()) {
            foreach ($rooms as $room) {
                if (str_starts_with($room->name, 'Room ')) {
                    $room->update(['status' => 'needs_cleaning']);
                }
            }
        } else {
            $names = explode(',', $booking->accommodations ?? '');

            foreach ($names as $name) {
                $cleanName = trim($name);

                if (str_starts_with($cleanName, 'Room ')) {
                    \App\Models\Accommodation::where('name', $cleanName)
                        ->update(['status' => 'needs_cleaning']);
                }
            }
        }

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        $this->broadcastAvailability($booking, 'admin_checked_out');

        return back()->with('success', 'Guest checked out successfully. Room is now marked for cleaning.');
    }

    public function markCleaned(Booking $booking)
    {
        if ($booking->status !== 'Checked Out') {
            return back()->with('error', 'Only checked-out bookings can be marked as cleaned.');
        }

        $oldStatus = $booking->status;

        $rooms = $booking->accommodations()->get();

        if ($rooms->isNotEmpty()) {
            foreach ($rooms as $room) {
                if (str_starts_with($room->name, 'Room ')) {
                    $room->update(['status' => 'available']);
                }
            }
        } else {
            $names = explode(',', $booking->accommodations ?? '');

            foreach ($names as $name) {
                $cleanName = trim($name);

                if (str_starts_with($cleanName, 'Room ')) {
                    \App\Models\Accommodation::where('name', $cleanName)
                        ->update(['status' => 'available']);
                }
            }
        }

        $booking->update([
            'status' => 'Completed',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'mark_cleaned',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => [
                'status' => $oldStatus,
            ],
            'new_values' => [
                'status' => $booking->status,
                'rooms' => 'cleaned',
            ],
            'ip_address' => request()->ip(),
        ]);

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        $this->broadcastAvailability($booking, 'admin_marked_cleaned');

        return back()->with('success', 'Rooms marked as cleaned and booking completed.');
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'Checked Out') {
            return back()->with('error', 'Only checked-out bookings can be completed.');
        }

        $oldStatus = $booking->status;

        $booking->update([
            'status' => 'Completed',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'complete_booking',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $booking->status],
            'ip_address' => request()->ip(),
        ]);

        \App\Events\BookingStatusUpdated::dispatch($booking);

        $this->broadcastAvailability($booking, 'admin_completed');

        return back()->with('success', 'Booking marked as completed.');
    }

    public function noShow(Booking $booking)
    {
        if (!in_array($booking->status, ['Confirmed', 'Checked In'], true)) {
            return back()->with('error', 'Only confirmed or checked-in bookings can be marked as no-show.');
        }

        $oldStatus = $booking->status;

        $booking->update([
            'status' => 'No Show',
        ]);

        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'mark_no_show',
            'model_type' => Booking::class,
            'model_id' => $booking->id,
            'old_values' => ['status' => $oldStatus],
            'new_values' => ['status' => $booking->status],
            'ip_address' => request()->ip(),
        ]);

        if ($booking->reward_points_used > 0 && $booking->user) {
            $booking->user->increment('reward_points', $booking->reward_points_used);

            RewardPoint::create([
                'user_id' => $booking->user->id,
                'booking_id' => $booking->id,
                'points' => $booking->reward_points_used,
                'type' => 'refunded_booking_noshow',
                'description' => 'Returned points from no-show Booking #' . $booking->id,
            ]);
        }

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        $this->broadcastAvailability($booking, 'admin_no_show');

        return back()->with('success', 'Booking marked as no-show.');
    }

    public function exportCsv()
    {
        $bookings = Booking::latest()->get();
        $filename = 'Bookings_Report_' . date('Y_m_d_His') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$filename",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Booking ID',
                'Guest Name',
                'Contact Number',
                'Accommodation',
                'Check-in',
                'Check-out',
                'Guests',
                'Payment Method',
                'Payment Status',
                'Booking Status',
                'Refund Status',
                'Total',
            ]);

            foreach ($bookings as $b) {
                $grandTotal = ($b->accommodation_total ?? 0)
                    + ($b->facility_total ?? 0)
                    - ($b->discount_amount ?? 0)
                    - ($b->reward_discount ?? 0);

                fputcsv($file, [
                    '#' . $b->id,
                    $b->guest_name,
                    $b->contact_number,
                    $b->accommodations,
                    $b->check_in,
                    $b->check_out,
                    $b->number_of_guests,
                    $b->payment_method,
                    $b->payment_status,
                    $b->status,
                    $b->refund_status ?? 'N/A',
                    number_format($grandTotal, 2),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        $bookings = Booking::latest()->get();

        $pdf = Pdf::loadView('admin.bookings-pdf', compact('bookings'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('Bookings_Report_' . date('Y_m_d_His') . '.pdf');
    }
}