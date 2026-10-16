<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        // =========================================
        // BOOKING SUMMARY
        // =========================================

        $totalBookings = Booking::count();

        $confirmedBookings = Booking::where(
            'status',
            'Confirmed'
        )->count();

        $pendingBookings = Booking::where(
            'status',
            'Pending'
        )->count();

        $cancelledBookings = Booking::where(
            'status',
            'Cancelled'
        )->count();

        $rejectedBookings = Booking::where(
            'status',
            'Rejected'
        )->count();

        // =========================================
        // TOTAL GUESTS
        // =========================================

        $totalGuests = Booking::whereIn(
            'status',
            ['Pending', 'Confirmed']
        )->sum('number_of_guests');

        // =========================================
        // PAYMENT SUMMARY
        // =========================================

        $cashBookings = Booking::where(
            'payment_method',
            'Cash'
        )->count();

        $gcashBookings = Booking::where(
            'payment_method',
            'GCash'
        )->count();

        // =========================================
        // RECENT BOOKINGS
        // =========================================

        $recentBookings = Booking::latest()
            ->take(10)
            ->get();

        // =========================================
        // CLICKABLE REPORT DETAILS
        // =========================================

        $paymentMethod = $request->query('payment_method');
        $details = $request->query('details');

        $detailBookings = collect();
        $detailTitle = null;

        if (in_array($paymentMethod, ['Cash', 'GCash'], true)) {
            $detailBookings = Booking::where(
                'payment_method',
                $paymentMethod
            )->latest()->get();

            $detailTitle = $paymentMethod . ' Payment Bookings';

        } elseif ($details === 'guests') {

            $detailBookings = Booking::whereIn(
                'status',
                ['Pending', 'Confirmed']
            )->latest()->get();

            $detailTitle = 'Guest Booking Details';

        } elseif ($details === 'all') {

            $detailBookings = Booking::latest()->get();

            $detailTitle = 'All Booking Details';
        }

        // =========================================
        // RETURN REPORTS PAGE
        // =========================================

        return view(
            'admin.reports',
            compact(
                'totalBookings',
                'confirmedBookings',
                'pendingBookings',
                'cancelledBookings',
                'rejectedBookings',
                'totalGuests',
                'cashBookings',
                'gcashBookings',
                'recentBookings',
                'detailBookings',
                'detailTitle'
            )
        );
    }
}