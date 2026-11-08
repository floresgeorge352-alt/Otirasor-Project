<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RefundRequestedNotification extends Notification
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
            ->subject('New Refund Request - Booking #' . $this->booking->id)
            ->greeting('Hello Admin,')
            ->line('A customer has requested a refund for Booking #' . $this->booking->id . '.')
            ->line('Guest: ' . $this->booking->guest_name)
            ->line('Amount: ₱' . number_format($this->booking->net_total, 2))
            ->line('Reason: ' . ($this->booking->refund_request_reason ?? 'No reason provided.'))
            ->action('Review Request', url('/admin/bookings?filter=refund_pending'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'type' => 'refund_requested',
            'message' => 'New refund request for Booking #' . $this->booking->id . '.',
        ];
    }
}