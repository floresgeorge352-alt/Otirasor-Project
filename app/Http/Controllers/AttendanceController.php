<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceCorrection;
use App\Models\User;
use App\Notifications\AttendanceCorrectionNotification;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    private function isScheduledWorkDay(User $user, Carbon $date): bool
    {
        $workDays = $user->work_days ?? [];
        if (!is_array($workDays) || empty($workDays)) return false;
        return in_array($date->format('l'), $workDays, true);
    }

    private function recordTimeIn(User $user)
    {
        $today = Carbon::today();
        $isWorkDay = $this->isScheduledWorkDay($user, $today);

        $attendance = Attendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['status' => 'Present']
        );

        if ($attendance->time_in) {
            return back()->with('error', 'You have already recorded your Time In today.');
        }

        $timeIn = now();
        $lateMinutes = 0;

        if ($isWorkDay && $user->regular_time_in) {
            $scheduledTimeIn = Carbon::parse($today->toDateString() . ' ' . $user->regular_time_in);
            $lateStartsAt = $scheduledTimeIn->copy()->addMinutes((int) $user->grace_period_minutes);

            if ($timeIn->greaterThan($lateStartsAt)) {
                $lateMinutes = (int) $lateStartsAt->diffInMinutes($timeIn);
            }
        }

        $attendance->update([
            'time_in' => $timeIn,
            'status' => 'Present',
            'late_minutes' => $lateMinutes,
        ]);

        if (!$isWorkDay) {
            return back()->with('success', 'Time In recorded on a rest day. Not an approved extra shift.');
        }

        return back()->with('success', 'Time In recorded. Late minutes: ' . $lateMinutes);
    }

    private function recordTimeOut(User $user)
    {
        $attendance = Attendance::where('user_id', $user->id)
            ->whereNull('time_out')
            ->latest('date')
            ->first();

        if (!$attendance || !$attendance->time_in) {
            return back()->with('error', 'You need to record your Time In first.');
        }

        $attendanceDate = Carbon::parse($attendance->date);
        $isWorkDay = $this->isScheduledWorkDay($user, $attendanceDate);

        $timeOut = now();
        $undertimeMinutes = 0;
        $overtimeMinutes = 0;
        $overtimeStatus = 'Not Requested';

        if ($isWorkDay && $user->regular_time_out) {
            $scheduledTimeOut = Carbon::parse($attendanceDate->toDateString() . ' ' . $user->regular_time_out);

            if ($scheduledTimeOut->lessThan($attendance->time_in)) {
                $scheduledTimeOut->addDay();
            }

            if ($timeOut->lessThan($scheduledTimeOut)) {
                $undertimeMinutes = (int) $timeOut->diffInMinutes($scheduledTimeOut);
            } elseif ($timeOut->greaterThan($scheduledTimeOut)) {
                $overtimeMinutes = (int) $scheduledTimeOut->diffInMinutes($timeOut);
                $overtimeStatus = 'Pending Approval';
            }
        }

        $attendance->update([
            'time_out' => $timeOut,
            'status' => 'Present',
            'undertime_minutes' => $undertimeMinutes,
            'overtime_minutes' => $overtimeMinutes,
            'overtime_status' => $overtimeStatus,
        ]);

        if (!$isWorkDay) {
            return back()->with('success', 'Time Out recorded on a rest day.');
        }

        return back()->with('success', "Time Out recorded. Undertime: {$undertimeMinutes}m. Overtime: {$overtimeMinutes}m.");
    }

    public function timeIn(Request $request)
    {
        return $this->recordTimeIn($request->user());
    }

    public function timeOut(Request $request)
    {
        return $this->recordTimeOut($request->user());
    }

    public function scan($employee)
    {
        $user = User::findOrFail($employee);
        abort_unless(auth()->user()->role === 'admin' || auth()->id() === $user->id, 403, 'Unauthorized access.');
        return view('employee.attendance-scan', ['employee' => $user]);
    }

    public function qrTimeIn($employee)
    {
        $user = User::findOrFail($employee);
        abort_unless(auth()->user()->role === 'admin' || auth()->id() === $user->id, 403, 'Unauthorized access.');
        return $this->recordTimeIn($user);
    }

    public function qrTimeOut($employee)
    {
        $user = User::findOrFail($employee);
        abort_unless(auth()->user()->role === 'admin' || auth()->id() === $user->id, 403, 'Unauthorized access.');
        return $this->recordTimeOut($user);
    }

    public function myAttendance(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2000 || $year > 2100) $year = now()->year;

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $records = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orderBy('date', 'desc')
            ->get();

        $daysPresent    = $records->whereNotNull('time_in')->count();
        $daysCompleted  = $records->whereNotNull('time_out')->count();
        $totalLate      = (int) $records->sum('late_minutes');
        $totalUndertime = (int) $records->sum('undertime_minutes');
        $totalOvertime  = (int) $records->sum('overtime_minutes');

        // === FIXED: Bawas ang unpaid_break_minutes sa worked hours ===
        // Ang break ay binabawas lang sa mga araw na nag-time in AT time out
        // at kung scheduled work day siya (kasi rest day = no break)
        $unpaidBreakMinutes = (int) ($user->unpaid_break_minutes ?? 0);

        $totalWorkedMinutes = $records
            ->filter(fn ($r) => $r->time_in && $r->time_out)
            ->sum(function ($r) use ($user, $unpaidBreakMinutes) {
                $workedMinutes = Carbon::parse($r->time_in)->diffInMinutes(Carbon::parse($r->time_out));

                // Bawas break lang kung work day ang araw na yun
                $isWorkDay = $this->isScheduledWorkDay($user, Carbon::parse($r->date));
                if ($isWorkDay) {
                    $workedMinutes -= $unpaidBreakMinutes;
                }

                return max(0, $workedMinutes); // huwag pabayaan maging negative
            });
        // ============================================================

        $summary = [
            'days_present'      => $daysPresent,
            'days_completed'    => $daysCompleted,
            'late_minutes'      => $totalLate,
            'undertime_minutes' => $totalUndertime,
            'overtime_minutes'  => $totalOvertime,
            'worked_hours'      => round($totalWorkedMinutes / 60, 2),
        ];

        $correctionRequests = AttendanceCorrection::where('user_id', $user->id)
            ->latest()
            ->get();

        return view('employee.my-attendance', compact(
            'records',
            'summary',
            'month',
            'year',
            'startOfMonth',
            'endOfMonth',
            'correctionRequests'
        ));
    }

    public function storeCorrection(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'time_in' => 'required|date_format:H:i',
            'time_out' => 'required|date_format:H:i|after:time_in',
            'reason' => 'required|string|max:1000',
        ]);

        $existing = Attendance::where('user_id', $request->user()->id)
            ->whereDate('date', $validated['date'])
            ->first();

        if ($existing && $existing->time_in && $existing->time_out) {
            return back()->with('error', 'You already have a complete attendance record for this date.');
        }

        $correction = AttendanceCorrection::create([
            'user_id' => $request->user()->id,
            'date' => $validated['date'],
            'time_in' => $validated['time_in'],
            'time_out' => $validated['time_out'],
            'reason' => $validated['reason'],
        ]);

        // Send real-time notification to all admins
        User::where('role', 'admin')->get()->each(function ($admin) use ($correction) {
            $admin->notify(new AttendanceCorrectionNotification($correction));
        });

        return back()->with('success', 'Correction request submitted. Please wait for admin approval.');
    }

    public function downloadMyCsv(Request $request)
    {
        $user = $request->user();
        $month = (int) $request->query('month', now()->month);
        $year  = (int) $request->query('year', now()->year);

        if ($month < 1 || $month > 12) $month = now()->month;
        if ($year < 2000 || $year > 2100) $year = now()->year;

        $startOfMonth = Carbon::create($year, $month, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        $records = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfMonth->toDateString(), $endOfMonth->toDateString()])
            ->orderBy('date', 'asc')
            ->get();

        $filename = 'My_Attendance_' . $startOfMonth->format('F_Y') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $unpaidBreakMinutes = (int) ($user->unpaid_break_minutes ?? 0);

        $callback = function() use ($records, $user, $unpaidBreakMinutes) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Date',
                'Time In',
                'Time Out',
                'Late (min)',
                'Undertime (min)',
                'Overtime (min)',
                'Worked Hours',
                'Status'
            ]);

            foreach ($records as $r) {
                // === FIXED: Compute worked hours with break deduction ===
                $workedHours = '—';
                if ($r->time_in && $r->time_out) {
                    $workedMinutes = Carbon::parse($r->time_in)->diffInMinutes(Carbon::parse($r->time_out));

                    $isWorkDay = $this->isScheduledWorkDay($user, Carbon::parse($r->date));
                    if ($isWorkDay) {
                        $workedMinutes -= $unpaidBreakMinutes;
                    }

                    $workedMinutes = max(0, $workedMinutes);
                    $workedHours = round($workedMinutes / 60, 2);
                }
                // =====================================================

                fputcsv($file, [
                    Carbon::parse($r->date)->format('M d, Y'),
                    $r->time_in ? Carbon::parse($r->time_in)->format('h:i A') : '—',
                    $r->time_out ? Carbon::parse($r->time_out)->format('h:i A') : '—',
                    $r->late_minutes ?? 0,
                    $r->undertime_minutes ?? 0,
                    $r->overtime_minutes ?? 0,
                    $workedHours,
                    $r->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}