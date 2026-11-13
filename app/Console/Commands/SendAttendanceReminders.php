<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Attendance;
use App\Notifications\AttendanceReminderNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendAttendanceReminders extends Command
{
    protected $signature = 'attendance:send-reminders';
    protected $description = 'Send Time In/Out reminders to employees based on their shift schedule';

    public function handle()
    {
        $now = Carbon::now();
        $todayStr = $now->toDateString();
        $dayOfWeek = $now->format('l'); // e.g., 'Monday'

        // Kunin lahat ng active employees na may shift ngayong araw
        $employees = User::where('role', 'employee')
            ->where('status', 'Active')
            ->whereNotNull('regular_time_in')
            ->whereNotNull('regular_time_out')
            ->get()
            ->filter(function ($employee) use ($dayOfWeek) {
                $workDays = $employee->work_days ?? [];
                return in_array($dayOfWeek, $workDays, true);
            });

        $timeInCount = 0;
        $timeOutCount = 0;

        foreach ($employees as $employee) {
            $attendance = Attendance::where('user_id', $employee->id)
                ->whereDate('date', $todayStr)
                ->first();

            // 1. TIME IN REMINDER (15 mins bago mag-umpisa ang shift)
            $scheduledTimeIn = Carbon::parse($todayStr . ' ' . $employee->regular_time_in);
            $reminderTimeIn = $scheduledTimeIn->copy()->subMinutes(15);

            if ($now->isSameMinute($reminderTimeIn) && (!$attendance || !$attendance->time_in)) {
                $employee->notify(new AttendanceReminderNotification('time_in'));
                $timeInCount++;
            }

            // 2. TIME OUT REMINDER (15 mins bago matapos ang shift)
            $scheduledTimeOut = Carbon::parse($todayStr . ' ' . $employee->regular_time_out);
            $reminderTimeOut = $scheduledTimeOut->copy()->subMinutes(15);

            if ($now->isSameMinute($reminderTimeOut) && $attendance && $attendance->time_in && !$attendance->time_out) {
                $employee->notify(new AttendanceReminderNotification('time_out'));
                $timeOutCount++;
            }
        }

        $this->info("Attendance reminders sent. Time-in reminders: {$timeInCount}, Time-out reminders: {$timeOutCount}");
    }
}