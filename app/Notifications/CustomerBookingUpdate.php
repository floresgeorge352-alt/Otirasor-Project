<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class CustomerBookingUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $messageText,
        public ?Booking $booking = null
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->messageText,
            'booking_id' => $this->booking?->id,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'message' => $this->messageText,
            'booking_id' => $this->booking?->id,
        ]);
    }
}