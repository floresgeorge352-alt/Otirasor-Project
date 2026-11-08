<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class DashboardStatsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $stats;

    public function __construct()
    {
        $this->stats = [
            'totalBookings' => Booking::count(),
            'pendingBookings' => Booking::where('status', 'Pending')->count(),
            'confirmedBookings' => Booking::where('status', 'Confirmed')->count(),
            'rejectedBookings' => Booking::where('status', 'Rejected')->count(),
            'cancelledBookings' => Booking::where('status', 'Cancelled')->count(),
            'totalGuests' => Booking::whereIn('status', ['Pending', 'Confirmed'])->sum('number_of_guests'),
        ];
    }

    public function broadcastOn(): array
    {
        return [new PrivateChannel('admin.dashboard')];
    }

    public function broadcastWith(): array
    {
        return [
            'stats' => $this->stats
        ];
    }
}