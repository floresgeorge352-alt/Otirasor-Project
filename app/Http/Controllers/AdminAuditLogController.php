<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminAuditLogController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->query('search', ''));

        $query = AuditLog::with('user')->latest();

        // Live Search Logic
        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('model_type', 'like', "%{$search}%")
                  ->orWhere('model_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(15)->withQueryString();

        // Kung AJAX request (galing sa live search), ibalik lang ang table part
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.audit-logs._table', compact('logs'))->render()
            ]);
        }

        return view('admin.audit-logs.index', compact('logs', 'search'));
    }
}