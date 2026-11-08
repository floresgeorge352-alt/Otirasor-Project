<?php

namespace App\Notifications;

use App\Models\AttendanceCorrection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AttendanceCorrectionNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(public AttendanceCorrection $correction) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'attendance_correction',
            'correction_id' => $this->correction->id,
            'employee_name' => $this->correction->user->name ?? 'Employee',
            'message' => ($this->correction->user->name ?? 'Employee') . ' requested an attendance correction for ' . \Carbon\Carbon::parse($this->correction->date)->format('M d, Y'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}