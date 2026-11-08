<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin.bookings')];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->booking->id,
            'guest_name' => $this->booking->guest_name,
            'check_in' => $this->booking->check_in,
            'check_out' => $this->booking->check_out,
            'status' => $this->booking->status,
            'total_amount' => $this->booking->accommodation_total + $this->booking->facility_total,
        ];
    }
}