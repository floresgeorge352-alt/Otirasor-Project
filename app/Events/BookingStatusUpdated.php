<?php

namespace App\Events;

use App\Models\Booking;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Booking $booking) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('customer.' . $this->booking->user_id),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->booking->id,
            'status' => $this->booking->status,
            'cancellation_status' => $this->booking->cancellation_status,
            'receipt_number' => $this->booking->receipt_number,
        ];
    }
}