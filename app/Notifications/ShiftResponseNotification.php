<?php

namespace App\Notifications;

use App\Models\ExtraShiftRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ShiftResponseNotification extends Notification
{
    use Queueable;

    public function __construct(public ExtraShiftRequest $shift) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type' => 'shift_response',
            'extra_shift_request_id' => $this->shift->id,
            'employee_name' => $this->shift->employee->name ?? 'Employee',
            'employee_response' => $this->shift->employee_response,
            'shift_date' => $this->shift->shift_date,
            'message' => ($this->shift->employee->name ?? 'Employee')
                . ' responded "' . $this->shift->employee_response . '" to a shift offer.',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}