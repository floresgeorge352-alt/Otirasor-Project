<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\RewardPoint;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\BookingRejectedNotification;
use App\Notifications\CancellationApprovedNotification;
use App\Notifications\CancellationRejectedNotification;
use App\Notifications\PaymentVerifiedNotification;
use App\Notifications\PaymentRejectedNotification;
use App\Notifications\RefundApprovedNotification;
use App\Notifications\RefundRejectedNotification;
use App\Mail\ReservationApproved;
use App\Mail\ReservationRejected;
use App\Mail\PaymentRejected;
use App\Mail\RefundProcessedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');
        $month = $request->query('month');
        $bookingId = $request->query('booking_id');

        $query = Booking::query();

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

    public function approve(Booking $booking)
    {
        if (
            $booking->payment_method === 'GCash'
            && $booking->payment_status !== 'Verified'
        ) {
            return back()->with('error', 'Verify the GCash payment before approving this booking.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'Confirmed',
                'receipt_number' => 'ER-' . str_pad($booking->id, 5, '0', STR_PAD_LEFT),
                'receipt_generated_at' => now(),
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

        return redirect('/admin/bookings?filter=confirmed')
            ->with('success', 'Booking approved successfully and e-receipt generated.');
    }

    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'status' => 'Rejected',
                'rejection_reason' => $request->rejection_reason,
            ]);

            // Return points
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

        return redirect('/admin/bookings?filter=rejected')
            ->with('success', 'Booking rejected successfully and email sent.');
    }

    public function verifyPayment(Booking $booking)
    {
        $booking->update(['payment_status' => 'Verified']);

        if ($booking->user) {
            $booking->user->notify(new PaymentVerifiedNotification($booking));
        }

        return redirect('/admin/bookings')->with('success', 'GCash payment verified successfully.');
    }

    public function rejectPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_rejection_reason' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($booking, $request) {
            $booking->update([
                'payment_status' => 'Rejected',
                'payment_rejection_reason' => $request->payment_rejection_reason,
                'refund_status' => $booking->status === 'Confirmed' ? 'Pending' : $booking->refund_status,
            ]);

            if ($booking->user) {
                $booking->user->notify(new PaymentRejectedNotification($booking));
            }

            $booking->load('user');
            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new PaymentRejected($booking));
            }
        });

        return redirect('/admin/bookings')->with('success', 'GCash payment rejected and email sent.');
    }

    public function refund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_notes' => 'nullable|string|max:1000',
        ]);

        $booking->update([
            'refund_status' => 'Refunded',
            'refunded_at' => now(),
            'refund_notes' => $request->refund_notes,
        ]);

        return redirect('/admin/bookings')->with('success', 'Booking marked as refunded successfully.');
    }

    public function approveRefund(Request $request, Booking $booking)
    {
        $request->validate([
            'refund_reference' => 'required|string|max:255',
            'refund_message' => 'nullable|string|max:1000',
        ]);

        if ($booking->refund_status !== 'Pending') {
            return back()->with('error', 'This refund request is not pending.');
        }

        $booking->update([
            'refund_status' => 'Refunded',
            'refunded_at' => now(),
            'refund_reference' => $request->refund_reference,
            'refund_message' => $request->refund_message,
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

        $booking->update([
            'refund_status' => 'Rejected',
            'refund_notes' => $request->refund_notes,
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

        DB::transaction(function () use ($booking) {
            $booking->update([
                'status' => 'Cancelled',
                'cancellation_status' => 'Approved',
            ]);

            // Return points
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

        return back()->with('success', 'Cancellation request approved.');
    }

    public function rejectCancellation(Booking $booking)
    {
        if ($booking->cancellation_status !== 'Pending') {
            return back()->with('error', 'There is no pending cancellation request.');
        }

        DB::transaction(function () use ($booking) {
            $booking->update([
                'cancellation_status' => 'Rejected',
            ]);

            if ($booking->user) {
                $booking->user->notify(new CancellationRejectedNotification($booking));
            }

            \App\Events\BookingStatusUpdated::dispatch($booking);
        });

        return back()->with('success', 'Cancellation request rejected. The booking remains confirmed.');
    }

    public function checkIn(Booking $booking)
    {
        if ($booking->status !== 'Confirmed') {
            return back()->with('error', 'Only confirmed bookings can be checked in.');
        }

        $booking->update(['status' => 'Checked In']);

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        return back()->with('success', 'Guest checked in successfully.');
    }

    public function checkOut(Booking $booking)
    {
        if ($booking->status !== 'Checked In') {
            return back()->with('error', 'Only checked-in bookings can be checked out.');
        }

        $booking->update(['status' => 'Checked Out']);

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
                    \App\Models\Accommodation::where('name', $cleanName)->update(['status' => 'needs_cleaning']);
                }
            }
        }

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        return back()->with('success', 'Guest checked out successfully. Room is now marked for cleaning.');
    }

    public function markCleaned(Booking $booking)
    {
        if ($booking->status !== 'Checked Out') {
            return back()->with('error', 'Only checked-out bookings can be marked as cleaned.');
        }

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
                    \App\Models\Accommodation::where('name', $cleanName)->update(['status' => 'available']);
                }
            }
        }

        $booking->update(['status' => 'Completed']);

        \App\Events\BookingStatusUpdated::dispatch($booking);
        \App\Events\RoomStatusUpdated::dispatch($booking);

        return back()->with('success', 'Rooms marked as cleaned and booking completed.');
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'Checked Out') {
            return back()->with('error', 'Only checked-out bookings can be completed.');
        }

        $booking->update(['status' => 'Completed']);

        \App\Events\BookingStatusUpdated::dispatch($booking);

        return back()->with('success', 'Booking marked as completed.');
    }

    public function noShow(Booking $booking)
    {
        if (!in_array($booking->status, ['Confirmed', 'Checked In'], true)) {
            return back()->with('error', 'Only confirmed or checked-in bookings can be marked as no-show.');
        }

        $booking->update(['status' => 'No Show']);

        // Return points
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

        return back()->with('success', 'Booking marked as no-show.');
    }
}