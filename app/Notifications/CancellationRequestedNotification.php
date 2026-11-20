<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
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
            'message'    => 'Customer ' . $this->booking->guest_name . ' requested a cancellation for Booking #' . $this->booking->id . '.',
            'url'        => '/admin/bookings?filter=pending_cancellation',
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'type'       => 'cancellation_requested',
            'booking_id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'message'    => 'Customer ' . $this->booking->guest_name . ' requested a cancellation.',
            'url'        => '/admin/bookings?filter=pending_cancellation',
        ]);
    }
}