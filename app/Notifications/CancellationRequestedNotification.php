<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CancellationRequestedNotification extends Notification
{
    use Queueable;

    public function __construct(public Booking $booking) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'type'       => 'cancellation_requested',
            'booking_id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'message'    => $this->booking->guest_name . ' requested cancellation.',
        ];
    }
}