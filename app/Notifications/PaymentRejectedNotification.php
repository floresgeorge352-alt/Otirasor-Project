<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejectedNotification extends Notification
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
            ->subject('Payment Rejected - Booking #' . $this->booking->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your ' . $this->booking->payment_method . ' payment for Booking #' . $this->booking->id . ' has been rejected.')
            ->line('Reason: ' . ($this->booking->payment_rejection_reason ?? 'No reason provided.'))
            ->line('Please contact support or submit a new proof of payment.')
            ->action('View My Bookings', url('/my-bookings'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => 'payment_rejected',
            'message' => 'Your payment for Booking #' . $this->booking->id . ' has been rejected.',
        ];
    }
}