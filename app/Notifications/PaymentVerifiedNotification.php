<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentVerifiedNotification extends Notification
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
            ->subject('Payment Verified - Booking #' . $this->booking->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your ' . $this->booking->payment_method . ' payment has been verified successfully.')
            ->line('Booking #' . $this->booking->id . ' is now awaiting admin approval.')
            ->action('View My Bookings', url('/my-bookings'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => 'payment_verified',
            'message' => 'Your payment for Booking #' . $this->booking->id . ' has been verified.',
        ];
    }
}