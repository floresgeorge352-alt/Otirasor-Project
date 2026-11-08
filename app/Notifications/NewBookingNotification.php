<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewBookingNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Booking $booking
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'number_of_guests' => $this->booking->number_of_guests,
            'check_in' => $this->booking->check_in,
            'check_out' => $this->booking->check_out,
            'message' => 'New booking received from ' . $this->booking->guest_name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'booking_id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'number_of_guests' => $this->booking->number_of_guests,
            'check_in' => $this->booking->check_in,
            'check_out' => $this->booking->check_out,
            'message' => 'New booking received from ' . $this->booking->guest_name,
        ]);
    }
}