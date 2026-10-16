<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use App\Notifications\BookingRejectedNotification;
use App\Mail\ReservationApproved;
use App\Mail\ReservationRejected;
use App\Mail\PaymentRejected;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'all');

        // If notification was clicked,
        // show only the specific booking.
        $bookingId = $request->query('booking_id');

        if ($bookingId) {

            $bookings = Booking::where(
                'id',
                $bookingId
            )
            ->get();

        } elseif ($filter === 'pending') {

            $bookings = Booking::where(
                'status',
                'Pending'
            )
            ->latest()
            ->get();

        } elseif ($filter === 'confirmed') {

            $bookings = Booking::where(
                'status',
                'Confirmed'
            )
            ->latest()
            ->get();

        } elseif ($filter === 'rejected') {

            $bookings = Booking::where(
                'status',
                'Rejected'
            )
            ->latest()
            ->get();

        } elseif ($filter === 'cancelled') {

            $bookings = Booking::where(
                'status',
                'Cancelled'
            )
            ->latest()
            ->get();

        } else {

            $bookings = Booking::latest()
                ->get();
        }

        return view(
            'admin.bookings',
            compact(
                'bookings',
                'filter'
            )
        );
    }


    // =========================================================
    // APPROVE BOOKING + GENERATE ELECTRONIC RECEIPT
    // =========================================================

    public function approve(Booking $booking)
    {
        $booking->update([
            'status' =>
                'Confirmed',

            'receipt_number' =>
                'ER-' . str_pad(
                    $booking->id,
                    5,
                    '0',
                    STR_PAD_LEFT
                ),

            'receipt_generated_at' =>
                now(),
        ]);

        // SEND CONFIRMED NOTIFICATION TO ADMINS
        User::where(
            'role',
            'admin'
        )
        ->get()
        ->each(
            function ($admin) use ($booking) {

                $admin->notify(
                    new BookingConfirmedNotification(
                        $booking
                    )
                );

            }
        );

        // SEND CONFIRMED EMAIL TO CUSTOMER
        $booking->load('user');

        Mail::to($booking->user->email)
            ->send(
                new ReservationApproved($booking)
            );

        // Redirect to Confirmed Bookings
        return redirect(
            '/admin/bookings?filter=confirmed'
        )
        ->with(
            'success',
            'Booking approved successfully and e-receipt generated.'
        );
    }


    // =========================================================
    // REJECT BOOKING
    // =========================================================

    public function reject(
        Request $request,
        Booking $booking
    ) {
        // VALIDATE BOOKING REJECTION REASON
        $request->validate([
            'rejection_reason' =>
                'required|string|max:1000',
        ]);

        // UPDATE BOOKING
        $booking->update([
            'status' =>
                'Rejected',

            'rejection_reason' =>
                $request->rejection_reason,
        ]);

        // SEND REJECTED NOTIFICATION TO ADMINS
        User::where(
            'role',
            'admin'
        )
        ->get()
        ->each(
            function ($admin) use ($booking) {

                $admin->notify(
                    new BookingRejectedNotification(
                        $booking
                    )
                );

            }
        );

        // SEND REJECTED EMAIL TO CUSTOMER
        $booking->load('user');

        Mail::to($booking->user->email)
            ->send(
                new ReservationRejected($booking)
            );

        // Redirect to Rejected Bookings
        return redirect(
            '/admin/bookings?filter=rejected'
        )
        ->with(
            'success',
            'Booking rejected successfully and email sent.'
        );
    }


    // =========================================================
    // VERIFY GCASH PAYMENT
    // =========================================================

    public function verifyPayment(Booking $booking)
    {
        $booking->update([
            'payment_status' =>
                'Verified',
        ]);

        return redirect('/admin/bookings')
            ->with(
                'success',
                'GCash payment verified successfully.'
            );
    }


    // =========================================================
    // REJECT GCASH PAYMENT
    // =========================================================

    public function rejectPayment(
        Request $request,
        Booking $booking
    ) {
        // VALIDATE PAYMENT REJECTION REASON
        $request->validate([
            'payment_rejection_reason' =>
                'required|string|max:1000',
        ]);

        // UPDATE PAYMENT STATUS AND REASON
        $booking->update([
            'payment_status' =>
                'Rejected',

            'payment_rejection_reason' =>
                $request->payment_rejection_reason,
        ]);

        // SEND PAYMENT REJECTION EMAIL TO CUSTOMER
        $booking->load('user');

        Mail::to($booking->user->email)
            ->send(
                new PaymentRejected($booking)
            );

        return redirect('/admin/bookings')
            ->with(
                'success',
                'GCash payment rejected and email sent.'
            );
    }
}