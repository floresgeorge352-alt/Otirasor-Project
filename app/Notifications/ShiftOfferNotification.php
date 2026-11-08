<?php

namespace App\Notifications;

use App\Models\ExtraShiftRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ShiftOfferNotification extends Notification
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
            'type' => 'shift_offer',
            'extra_shift_request_id' => $this->shift->id,
            'shift_date' => $this->shift->shift_date,
            'start_time' => $this->shift->start_time,
            'end_time' => $this->shift->end_time,
            'message' => 'Shift update for ' . \Carbon\Carbon::parse($this->shift->shift_date)->format('M d, Y'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}