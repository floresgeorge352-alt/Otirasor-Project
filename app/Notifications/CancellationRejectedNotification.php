<?php

namespace App\Notifications;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancellationRejectedNotification extends Notification
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
            ->subject('Cancellation Request Rejected - Booking #' . $this->booking->id)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your cancellation request for Booking #' . $this->booking->id . ' has been rejected.')
            ->line('Your booking remains confirmed.')
            ->line('Check-in: ' . Carbon::parse($this->booking->check_in)->format('M d, Y'))
            ->line('Check-out: ' . Carbon::parse($this->booking->check_out)->format('M d, Y'))
            ->action('View My Bookings', url('/my-bookings'))
            ->salutation('Thank you, ' . config('app.name'));
    }

    public function toArray($notifiable): array
    {
        return [
            'booking_id' => $this->booking->id,
            'type' => 'cancellation_rejected',
            'message' => 'Your cancellation request for Booking #' . $this->booking->id . ' has been rejected.',
        ];
    }
}