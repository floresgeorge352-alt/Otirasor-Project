<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingReminder;

class SendBookingReminders extends Command
{
    protected $signature = 'reminders:bookings';
    protected $description = 'Send email reminders to customers 1 day before check-in';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();
        
        // Kunin ang mga Confirmed bookings na mag-check-in bukas
        $bookings = Booking::where('status', 'Confirmed')
            ->whereDate('check_in', $tomorrow)
            ->with('user')
            ->get();

        if ($bookings->isEmpty()) {
            $this->info('No bookings to remind for tomorrow.');
            return;
        }

        foreach ($bookings as $booking) {
            if ($booking->user && $booking->user->email) {
                try {
                    Mail::to($booking->user->email)->send(new BookingReminder($booking));
                    
                    // Determine kung Day Use o Overnight
                    $checkInDate = Carbon::parse($booking->check_in)->format('Y-m-d');
                    $checkOutDate = Carbon::parse($booking->check_out)->format('Y-m-d');
                    $type = ($checkInDate === $checkOutDate) ? 'Day Use' : 'Overnight';
                            
                    $this->info("Reminder sent to: {$booking->user->email} (Booking #{$booking->id}, {$type})");
                } catch (\Exception $e) {
                    $this->error("Failed to send to {$booking->user->email}: " . $e->getMessage());
                }
            }
        }

        $this->info('All reminders processed.');
    }
}