<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceReminderNotification extends Notification
{
    use Queueable;

    public $type;
    public $message;

    /**
     * @param string $type 'time_in' or 'time_out'
     */
    public function __construct(string $type)
    {
        $this->type = $type;
        $this->message = $type === 'time_in' 
            ? 'Reminder: Your shift is about to start. Please don\'t forget to Time In.'
            : 'Reminder: Your shift is almost over. Please don\'t forget to Time Out.';
    }

    public function via(object $notifiable): array
    {
        return ['database']; // Pwede mong dagdagan ng 'mail' kung gusto mo ng email
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'attendance_reminder',
            'reminder_type' => $this->type,
            'message' => $this->message,
            'url' => '/employee/my-attendance',
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Attendance Reminder')
            ->line($this->message)
            ->action('Go to My Attendance', url('/employee/my-attendance'))
            ->line('Thank you for using our system!');
    }
}