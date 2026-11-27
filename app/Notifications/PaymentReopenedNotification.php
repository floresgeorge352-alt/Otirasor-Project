<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentReopenedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Booking $booking)
    {
    }

    public function via($notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Re-opened - Booking #' . $this->booking->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your payment proof for Booking #' . $this->booking->id . ' has been re-opened by the admin.')
            ->line('Please log in to your account and re-upload a valid GCash payment proof.')
            ->action('Re-upload Payment Proof', url('/my-bookings'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => 'payment_reopened',
            'message' => 'Admin requested a new payment proof for Booking #' . $this->booking->id . '. Please re-upload.',
        ];
    }
}