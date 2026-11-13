<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminAttendanceController extends Controller
{
    /**
     * Helper: compute worked minutes with break deduction.
     */
    private function computeWorkedMinutes($records, User $employee): int
    {
        $unpaidBreakMinutes = (int) ($employee->unpaid_break_minutes ?? 0);
        $workDays = $employee->work_days ?? [];

        return $records
            ->filter(fn ($r) => $r->time_in && $r->time_out)
            ->sum(function ($r) use ($unpaidBreakMinutes, $workDays) {
                $workedMinutes = Carbon::parse($r->time_in)->diffInMinutes(Carbon::parse($r->time_out));

                $isWorkDay = in_array(Carbon::parse($r->date)->format('l'), $workDays, true);
                if ($isWorkDay) {
                    $workedMinutes -= $unpaidBreakMinutes;
                }

                return max(0, $workedMinutes);
            });
    }

    public function index(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);
        $day   = $request->query('day');
        $search = trim($request->query('search', ''));

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2000 || $year > 2100) $year = now()->year;

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $query = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('time_in', 'desc');

        if ($day) {
            $filterDate = Carbon::create($year, $month, (int)$day)->toDateString();
            $query->whereDate('date', $filterDate);
        }

        if ($search !== '') {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $attendances = $query->get();

        $employeesQuery = User::where('role', 'employee')->orderBy('name');
        
        if ($search !== '') {
            $employeesQuery->where('name', 'like', "%{$search}%");
        }
        
        $employees = $employeesQuery->get();
        $summaries = [];

        foreach ($employees as $employee) {
            $records = Attendance::where('user_id', $employee->id)
                ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $daysPresent    = $records->whereNotNull('time_in')->count();
            $daysCompleted  = $records->whereNotNull('time_out')->count();
            $totalLate      = (int) $records->sum('late_minutes');
            $totalUndertime = (int) $records->sum('undertime_minutes');
            $totalOvertime  = (int) $records->sum('overtime_minutes');

            $totalWorkedMinutes = $this->computeWorkedMinutes($records, $employee);

            $summaries[] = [
                'employee'          => $employee,
                'days_present'      => $daysPresent,
                'days_completed'    => $daysCompleted,
                'late_minutes'      => $totalLate,
                'undertime_minutes' => $totalUndertime,
                'overtime_minutes'  => $totalOvertime,
                'worked_hours'      => round($totalWorkedMinutes / 60, 2),
            ];
        }

        return view('admin.attendance.index', compact(
            'attendances',
            'summaries',
            'month',
            'year',
            'day',
            'search',
            'startOfMonth',
            'endOfMonth'
        ));
    }

    // === BAGONG METHOD PARA SA AJAX MONTHLY SUMMARY ===
    public function searchSummary(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);
        $search = trim($request->query('search', ''));
        
        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $employeesQuery = User::where('role', 'employee')->orderBy('name');
        if ($search !== '') {
            $employeesQuery->where('name', 'like', "%{$search}%");
        }
        
        $employees = $employeesQuery->get();
        $summaries = [];

        foreach ($employees as $employee) {
            $records = Attendance::where('user_id', $employee->id)
                ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $daysPresent    = $records->whereNotNull('time_in')->count();
            $daysCompleted  = $records->whereNotNull('time_out')->count();
            $totalLate      = (int) $records->sum('late_minutes');
            $totalUndertime = (int) $records->sum('undertime_minutes');
            $totalOvertime  = (int) $records->sum('overtime_minutes');

            $totalWorkedMinutes = $this->computeWorkedMinutes($records, $employee);

            $summaries[] = [
                'employee'          => $employee,
                'days_present'      => $daysPresent,
                'days_completed'    => $daysCompleted,
                'late_minutes'      => $totalLate,
                'undertime_minutes' => $totalUndertime,
                'overtime_minutes'  => $totalOvertime,
                'worked_hours'      => round($totalWorkedMinutes / 60, 2),
            ];
        }

        return response()->json([
            'html' => view('admin.attendance._summary_table', compact('summaries'))->render()
        ]);
    }

    // === BAGONG METHOD PARA SA AJAX DAILY RECORDS ===
    public function searchDaily(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);
        $day   = $request->query('day');
        $search = trim($request->query('search', ''));

        $query = Attendance::with('user')
            ->orderBy('date', 'desc')
            ->orderBy('time_in', 'desc');

        if ($day) {
            $filterDate = Carbon::create($year, $month, (int)$day)->toDateString();
            $query->whereDate('date', $filterDate);
        }

        if ($search !== '') {
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $attendances = $query->get();

        return response()->json([
            'html' => view('admin.attendance._daily_table', compact('attendances'))->render()
        ]);
    }

    public function approveOvertime($id)
    {
        $attendance = Attendance::findOrFail($id);
        if ($attendance->overtime_minutes <= 0) return back()->with('error', 'There is no overtime to approve.');
        if ($attendance->overtime_status !== 'Pending Approval') return back()->with('error', 'This overtime is not pending approval.');
        $attendance->update(['overtime_status' => 'Approved']);
        return back()->with('success', 'Overtime approved successfully.');
    }

    public function rejectOvertime($id)
    {
        $attendance = Attendance::findOrFail($id);
        if ($attendance->overtime_minutes <= 0) return back()->with('error', 'There is no overtime to reject.');
        if ($attendance->overtime_status !== 'Pending Approval') return back()->with('error', 'This overtime is not pending approval.');
        $attendance->update(['overtime_status' => 'Rejected']);
        return back()->with('success', 'Overtime rejected successfully.');
    }

    public function downloadCsv(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2000 || $year > 2100) $year = now()->year;

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $employees = User::where('role', 'employee')->orderBy('name')->get();
        $filename = 'Attendance_Summary_' . $startOfMonth->format('F_Y') . '.csv';
        $controller = $this;

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($employees, $startOfMonth, $endOfMonth, $controller) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Employee', 'Days Present', 'Days Completed', 'Worked Hours', 'Late (min)', 'Undertime (min)', 'Overtime (min)']);

            foreach ($employees as $employee) {
                $records = Attendance::where('user_id', $employee->id)
                    ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                    ->get();

                $daysPresent    = $records->whereNotNull('time_in')->count();
                $daysCompleted  = $records->whereNotNull('time_out')->count();
                $totalLate      = (int) $records->sum('late_minutes');
                $totalUndertime = (int) $records->sum('undertime_minutes');
                $totalOvertime  = (int) $records->sum('overtime_minutes');

                $totalWorkedMinutes = $controller->computeWorkedMinutes($records, $employee);

                fputcsv($file, [$employee->name, $daysPresent, $daysCompleted, round($totalWorkedMinutes / 60, 2), $totalLate, $totalUndertime, $totalOvertime]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function downloadPdf(Request $request)
    {
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2000 || $year > 2100) $year = now()->year;

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $employees = User::where('role', 'employee')->orderBy('name')->get();
        $summaries = [];

        foreach ($employees as $employee) {
            $records = Attendance::where('user_id', $employee->id)
                ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
                ->get();

            $daysPresent    = $records->whereNotNull('time_in')->count();
            $daysCompleted  = $records->whereNotNull('time_out')->count();
            $totalLate      = (int) $records->sum('late_minutes');
            $totalUndertime = (int) $records->sum('undertime_minutes');
            $totalOvertime  = (int) $records->sum('overtime_minutes');

            $totalWorkedMinutes = $this->computeWorkedMinutes($records, $employee);

            $summaries[] = [
                'employee'          => $employee,
                'days_present'      => $daysPresent,
                'days_completed'    => $daysCompleted,
                'late_minutes'      => $totalLate,
                'undertime_minutes' => $totalUndertime,
                'overtime_minutes'  => $totalOvertime,
                'worked_hours'      => round($totalWorkedMinutes / 60, 2),
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.attendance.pdf', compact('summaries', 'startOfMonth', 'endOfMonth', 'month', 'year'));
        $pdf->setPaper('A4', 'landscape');

        $filename = 'Attendance_Summary_' . $startOfMonth->format('F_Y') . '.pdf';
        return $pdf->download($filename);
    }

    // =========================================================
    // ATTENDANCE CORRECTIONS
    // =========================================================

    public function corrections()
    {
        $requests = AttendanceCorrection::with('user')->latest()->get();
        return view('admin.attendance.corrections', compact('requests'));
    }

    public function approveCorrection(AttendanceCorrection $correction)
    {
        $correction->update(['status' => 'Approved']);

        $attendance = Attendance::firstOrCreate(
            ['user_id' => $correction->user_id, 'date' => $correction->date],
            ['status' => 'Present']
        );

        $attendance->update([
            'time_in' => $correction->time_in,
            'time_out' => $correction->time_out,
            'status' => 'Present',
        ]);

        return back()->with('success', 'Correction approved and attendance record updated.');
    }

    public function rejectCorrection(AttendanceCorrection $correction)
    {
        $correction->update(['status' => 'Rejected']);
        return back()->with('success', 'Correction request rejected.');
    }
}