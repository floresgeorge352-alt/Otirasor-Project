<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        // Search
        $search = trim($request->query('search', ''));

        // Action Filter
        $action = trim($request->query('action', ''));

        // Date Range Filter
        $dateFrom = $request->query('date_from', '');
        $dateTo = $request->query('date_to', '');

        $query = AuditLog::with('user')->latest();

        // Live Search
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('model_type', 'like', "%{$search}%")
                    ->orWhere('model_id', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Action Filter
        if ($action !== '') {
            $query->where('action', $action);
        }

        // Date From
        if ($dateFrom !== '') {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        // Date To
        if ($dateTo !== '') {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        // Pagination
        $logs = $query->paginate(15)->withQueryString();

        // AJAX Response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.audit-logs._table', compact('logs'))->render()
            ]);
        }

        return view('admin.audit-logs.index', compact(
            'logs',
            'search',
            'action',
            'dateFrom',
            'dateTo'
        ));
    }
}