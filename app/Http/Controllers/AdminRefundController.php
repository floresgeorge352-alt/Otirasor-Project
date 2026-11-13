<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class AdminRefundController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));
        $filter = $request->query('filter', 'successful'); // Default tab

        // Base Query
        $query = Booking::query();

        // Filter Logic (Tab)
        if ($filter === 'rejected') {
            $query->where('refund_status', 'Rejected');
        } else {
            $query->where('refund_status', 'Refunded');
        }

        // Search Logic
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('refund_reference', 'like', "%{$search}%");
            });
        }

        $refunds = $query->latest('refunded_at')->paginate(10)->withQueryString();

        // Kung AJAX request, ibalik ang JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.refunds._table', compact('refunds', 'filter'))->render()
            ]);
        }

        return view('admin.refunds.index', compact('refunds', 'search', 'filter'));
    }
}