<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('time_in', 'desc');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->get();

        return view('admin.attendance.index', compact('attendances'));
    }

    public function approveOvertime($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->overtime_minutes <= 0) {
            return back()->with(
                'error',
                'There is no overtime to approve.'
            );
        }

        if ($attendance->overtime_status !== 'Pending Approval') {
            return back()->with(
                'error',
                'This overtime is not pending approval.'
            );
        }

        $attendance->update([
            'overtime_status' => 'Approved',
        ]);

        return back()->with(
            'success',
            'Overtime approved successfully.'
        );
    }

    public function rejectOvertime($id)
    {
        $attendance = Attendance::findOrFail($id);

        if ($attendance->overtime_minutes <= 0) {
            return back()->with(
                'error',
                'There is no overtime to reject.'
            );
        }

        if ($attendance->overtime_status !== 'Pending Approval') {
            return back()->with(
                'error',
                'This overtime is not pending approval.'
            );
        }

        $attendance->update([
            'overtime_status' => 'Rejected',
        ]);

        return back()->with(
            'success',
            'Overtime rejected successfully.'
        );
    }
}