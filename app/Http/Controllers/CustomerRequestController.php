<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class CustomerRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $query = Booking::where('user_id', Auth::id())
            ->where(function($q) {
                $q->whereNotNull('refund_status')
                  ->orWhereNotNull('cancellation_status');
            });

        // Search logic: Booking ID, Reason, or Reference No.
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('refund_request_reason', 'like', "%{$search}%")
                  ->orWhere('cancellation_reason', 'like', "%{$search}%")
                  ->orWhere('refund_reference', 'like', "%{$search}%");
            });
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        return view('customer.requests', compact('requests', 'search'));
    }
}