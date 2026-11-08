<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefundApprovedNotification extends Notification
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
            ->subject('Refund Approved - Booking #' . $this->booking->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your refund request for Booking #' . $this->booking->id . ' has been approved.')
            ->line('Amount Refunded: ₱' . number_format($this->booking->net_total, 2))
            ->line('GCash Reference No.: ' . ($this->booking->refund_reference ?? 'N/A'))
            ->action('View My Bookings', url('/my-bookings'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => 'refund_approved',
            'message' => 'Your refund for Booking #' . $this->booking->id . ' has been approved.',
        ];
    }
}