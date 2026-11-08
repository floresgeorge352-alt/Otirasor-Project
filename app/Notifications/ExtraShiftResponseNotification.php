<?php

namespace App\Notifications;

use App\Models\ExtraShiftRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ExtraShiftResponseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public ExtraShiftRequest $extraShiftRequest
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'extra_shift_request_id' => $this->extraShiftRequest->id,
            'employee_name' => $this->extraShiftRequest->employee->name ?? 'Unknown',
            'shift_date' => $this->extraShiftRequest->shift_date?->format('M d, Y'),
            'employee_response' => $this->extraShiftRequest->employee_response,
            'message' => ($this->extraShiftRequest->employee->name ?? 'Employee')
                . ' responded: '
                . $this->extraShiftRequest->employee_response
                . ' for the shift offer ('
                . $this->extraShiftRequest->shift_date?->format('M d, Y')
                . ')',
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'extra_shift_request_id' => $this->extraShiftRequest->id,
            'employee_name' => $this->extraShiftRequest->employee->name ?? 'Unknown',
            'shift_date' => $this->extraShiftRequest->shift_date?->format('M d, Y'),
            'employee_response' => $this->extraShiftRequest->employee_response,
            'message' => ($this->extraShiftRequest->employee->name ?? 'Employee')
                . ' responded: '
                . $this->extraShiftRequest->employee_response
                . ' for the shift offer ('
                . $this->extraShiftRequest->shift_date?->format('M d, Y')
                . ')',
        ]);
    }
}