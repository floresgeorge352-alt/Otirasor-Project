<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Check Employee Work Schedule
    |--------------------------------------------------------------------------
    */

    private function isScheduledWorkDay(User $user, Carbon $date): bool
    {
        $workDays = $user->work_days ?? [];

        if (!is_array($workDays) || empty($workDays)) {
            return false;
        }

        return in_array(
            $date->format('l'),
            $workDays,
            true
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Shared Time In Logic
    |--------------------------------------------------------------------------
    */

    private function recordTimeIn(User $user)
    {
        $today = Carbon::today();
        $isWorkDay = $this->isScheduledWorkDay($user, $today);

        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $user->id,
                'date' => $today,
            ],
            [
                'status' => 'Present',
            ]
        );

        if ($attendance->time_in) {
            return back()->with(
                'error',
                'You have already recorded your Time In today.'
            );
        }

        $timeIn = now();
        $lateMinutes = 0;

        // Late minutes apply only on scheduled workdays.
        if ($isWorkDay && $user->regular_time_in) {
            $scheduledTimeIn = Carbon::parse(
                $today->toDateString() . ' ' .
                $user->regular_time_in
            );

            $lateStartsAt = $scheduledTimeIn->copy()->addMinutes(
                (int) $user->grace_period_minutes
            );

            if ($timeIn->greaterThan($lateStartsAt)) {
                $lateMinutes = (int) $lateStartsAt->diffInMinutes(
                    $timeIn
                );
            }
        }

        $attendance->update([
            'time_in' => $timeIn,
            'status' => 'Present',
            'late_minutes' => $lateMinutes,
        ]);

        if (!$isWorkDay) {
            return back()->with(
                'success',
                'Time In recorded successfully on a rest day. ' .
                'This attendance is not automatically an approved extra shift.'
            );
        }

        return back()->with(
            'success',
            'Time In recorded successfully. Late minutes: ' .
            $lateMinutes
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Shared Time Out Logic
    |--------------------------------------------------------------------------
    */

    private function recordTimeOut(User $user)
    {
        $today = Carbon::today();
        $isWorkDay = $this->isScheduledWorkDay($user, $today);

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        if (!$attendance || !$attendance->time_in) {
            return back()->with(
                'error',
                'You need to record your Time In first.'
            );
        }

        if ($attendance->time_out) {
            return back()->with(
                'error',
                'You have already recorded your Time Out today.'
            );
        }

        $timeOut = now();
        $undertimeMinutes = 0;
        $overtimeMinutes = 0;
        $overtimeStatus = 'Not Requested';

        // Regular undertime/overtime calculations apply only
        // when the employee is scheduled to work that day.
        if ($isWorkDay && $user->regular_time_out) {
            $scheduledTimeOut = Carbon::parse(
                $today->toDateString() . ' ' .
                $user->regular_time_out
            );

            if ($timeOut->lessThan($scheduledTimeOut)) {
                $undertimeMinutes = (int) $timeOut->diffInMinutes(
                    $scheduledTimeOut
                );
            } elseif ($timeOut->greaterThan($scheduledTimeOut)) {
                $overtimeMinutes = (int) $scheduledTimeOut->diffInMinutes(
                    $timeOut
                );

                // Overtime still requires admin review.
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
            return back()->with(
                'success',
                'Time Out recorded successfully on a rest day. ' .
                'Any extra shift must be confirmed separately.'
            );
        }

        return back()->with(
            'success',
            'Time Out recorded successfully. ' .
            'Undertime: ' . $undertimeMinutes . ' minutes. ' .
            'Overtime for review: ' . $overtimeMinutes . ' minutes.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Attendance
    |--------------------------------------------------------------------------
    */

    public function timeIn(Request $request)
    {
        return $this->recordTimeIn($request->user());
    }

    public function timeOut(Request $request)
    {
        return $this->recordTimeOut($request->user());
    }

    /*
    |--------------------------------------------------------------------------
    | QR Attendance
    |--------------------------------------------------------------------------
    */

    public function scan($employee)
    {
        $user = User::findOrFail($employee);

        return view('employee.attendance-scan', [
            'employee' => $user,
        ]);
    }

    public function qrTimeIn($employee)
    {
        $user = User::findOrFail($employee);

        return $this->recordTimeIn($user);
    }

    public function qrTimeOut($employee)
    {
        $user = User::findOrFail($employee);

        return $this->recordTimeOut($user);
    }
}