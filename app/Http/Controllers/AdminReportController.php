<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $totalBookings = Booking::count();

        $confirmedBookings = Booking::where('status', 'Confirmed')->count();
        $pendingBookings   = Booking::where('status', 'Pending')->count();
        $cancelledBookings = Booking::where('status', 'Cancelled')->count();
        $rejectedBookings  = Booking::where('status', 'Rejected')->count();

        $totalGuests = Booking::whereIn('status', ['Pending', 'Confirmed'])
            ->sum('number_of_guests');

        $cashBookings  = Booking::where('payment_method', 'Cash')->count();
        $gcashBookings = Booking::where('payment_method', 'GCash')->count();

        $recentBookings = Booking::latest()->take(10)->get();

        $paymentMethod = $request->query('payment_method');
        $details       = $request->query('details');

        $detailBookings = collect();
        $detailTitle    = null;

        if (in_array($paymentMethod, ['Cash', 'GCash'], true)) {
            $detailBookings = Booking::where('payment_method', $paymentMethod)
                ->latest()
                ->get();

            $detailTitle = $paymentMethod . ' Payment Bookings';
        } elseif ($details === 'guests') {
            $detailBookings = Booking::whereIn('status', ['Pending', 'Confirmed'])
                ->latest()
                ->get();

            $detailTitle = 'Guest Booking Details';
        } elseif ($details === 'all') {
            $detailBookings = Booking::latest()->get();
            $detailTitle    = 'All Booking Details';
        }

        return view('admin.reports', compact(
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
        ));
    }

    public function payments(Request $request)
    {
        $statusFilter = $request->query('status');

        $query = Booking::whereNotNull('payment_method');

        // --- CLICKABLE REVENUE CARDS LOGIC ---
        if ($statusFilter === 'Booked') {
            $query->whereIn('status', ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Completed']);
        } elseif ($statusFilter === 'Realized') {
            $query->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed']);
        } elseif (in_array($statusFilter, ['Verified', 'For Verification', 'Rejected'])) {
            $query->where('payment_status', $statusFilter);
        }
        // --------------------------------------

        $payments = $query->latest()->paginate(10)->withQueryString();

        $allPayments = Booking::whereNotNull('payment_method')->get();

        // === FIXED: Gamit na ang net_total accessor (bawas discount) ===
        $bookedRevenue = $allPayments
            ->whereIn('status', ['Pending', 'Confirmed', 'Checked In', 'Checked Out', 'Completed'])
            ->sum(fn ($booking) => $booking->net_total);

        $realizedRevenue = $allPayments
            ->whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed'])
            ->sum(fn ($booking) => $booking->net_total);
        // ================================================================

        $verifiedPayments = $allPayments->where('payment_status', 'Verified')->count();
        $pendingPayments  = $allPayments->where('payment_status', 'For Verification')->count();
        $rejectedPayments = $allPayments->where('payment_status', 'Rejected')->count();

        return view('admin.payments', compact(
            'payments',
            'bookedRevenue',
            'realizedRevenue',
            'verifiedPayments',
            'pendingPayments',
            'rejectedPayments',
            'statusFilter'
        ));
    }

    public function reviews(Request $request)
    {
        $ratingFilter = $request->query('rating');

        $query = \App\Models\Review::with(['user', 'booking']);

        if (in_array($ratingFilter, ['1', '2', '3', '4', '5'])) {
            $query->where('rating', $ratingFilter);
        }

        $reviews = $query->latest()->get();

        $starCounts = [
            '5' => \App\Models\Review::where('rating', 5)->count(),
            '4' => \App\Models\Review::where('rating', 4)->count(),
            '3' => \App\Models\Review::where('rating', 3)->count(),
            '2' => \App\Models\Review::where('rating', 2)->count(),
            '1' => \App\Models\Review::where('rating', 1)->count(),
        ];

        return view('admin.reviews', compact('reviews', 'ratingFilter', 'starCounts'));
    }
}