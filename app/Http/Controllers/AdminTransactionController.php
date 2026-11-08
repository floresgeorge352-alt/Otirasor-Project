<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $search = trim($request->query('search', ''));

        // Ginamit natin ang check_in para accurate ang month ng bakasyon
        $query = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed', 'Cancelled'])
            ->whereMonth('check_in', $month)
            ->whereYear('check_in', $year);

        // Search Logic
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('gcash_reference', 'like', "%{$search}%")
                  ->orWhere('refund_reference', 'like', "%{$search}%");
            });
        }

        // Kunin lahat ng filtered transactions para sa computation ng totals
        $allFilteredTransactions = $query->get();

        // === FIXED: Gamit na ang net_total accessor (bawas discount) ===
        $totalRevenue = 0;
        $totalRefunds = 0;

        foreach ($allFilteredTransactions as $t) {
            $netTotal = $t->net_total;

            $totalRevenue += $netTotal;

            if ($t->refund_status === 'Refunded') {
                $totalRefunds += $netTotal;
            }
        }

        $netIncome = $totalRevenue - $totalRefunds;
        // ================================================================

        // Pagination para sa table (Ginamitan ng appends para hindi mawala ang filter sa page 2)
        $transactions = $query->latest()->paginate(10)->appends([
            'month' => $month,
            'year' => $year,
            'search' => $search,
        ]);

        return view('admin.transactions.index', compact(
            'transactions', 'totalRevenue', 'totalRefunds', 'netIncome', 'month', 'year', 'search'
        ));
    }

    public function exportCsv(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $search = trim($request->query('search', ''));

        // Ginamit natin ang check_in para accurate ang month ng bakasyon
        $query = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed', 'Cancelled'])
            ->whereMonth('check_in', $month)
            ->whereYear('check_in', $year);

        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('gcash_reference', 'like', "%{$search}%")
                  ->orWhere('refund_reference', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->get();

        $filename = 'Transaction_Report_' . date('F_Y', mktime(0, 0, 0, $month, 1, $year)) . '.csv';

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function() use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Booking ID', 'Guest Name', 'Payment Method', 'Status', 'Subtotal', 'Discount', 'Total Paid', 'Refund Status']);

            foreach ($transactions as $t) {
                // === FIXED: Gamit ang accessor para consistent sa index() ===
                $subtotal = (float) ($t->accommodation_total ?? 0) + (float) ($t->facility_total ?? 0);
                $discount = (float) ($t->discount_amount ?? 0);
                $total = $t->net_total;
                // ==========================================================

                fputcsv($file, [
                    Carbon::parse($t->created_at)->format('Y-m-d'),
                    '#' . $t->id,
                    $t->guest_name,
                    $t->payment_method,
                    $t->status,
                    number_format($subtotal, 2),
                    number_format($discount, 2),
                    number_format($total, 2),
                    $t->refund_status ?? 'N/A'
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // =========================================================
    // ✅ BAGONG METHOD — PDF Export
    // =========================================================
    public function exportPdf(Request $request)
    {
        $month = $request->query('month', now()->month);
        $year = $request->query('year', now()->year);
        $search = trim($request->query('search', ''));

        $query = Booking::whereIn('status', ['Confirmed', 'Checked In', 'Checked Out', 'Completed', 'Cancelled'])
            ->whereMonth('check_in', $month)
            ->whereYear('check_in', $year);

        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhere('guest_name', 'like', "%{$search}%")
                  ->orWhere('gcash_reference', 'like', "%{$search}%")
                  ->orWhere('refund_reference', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->get();

        $totalRevenue = 0;
        $totalRefunds = 0;

        foreach ($transactions as $t) {
            $netTotal = $t->net_total;
            $totalRevenue += $netTotal;

            if ($t->refund_status === 'Refunded') {
                $totalRefunds += $netTotal;
            }
        }

        $netIncome = $totalRevenue - $totalRefunds;

        $monthName = date('F', mktime(0, 0, 0, $month, 1));
        $filename = 'Transaction_Report_' . $monthName . '_' . $year . '.pdf';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
            'admin.transactions.pdf',
            compact('transactions', 'totalRevenue', 'totalRefunds', 'netIncome', 'month', 'year', 'monthName', 'search')
        );
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download($filename);
    }
}