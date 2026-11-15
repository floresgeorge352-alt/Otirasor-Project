<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class AccommodationAvailabilityChanged implements ShouldBroadcast
{
    use Dispatchable;

    public function __construct(
        public int $accommodationId,
        public bool $available
    ) {}

    public function broadcastOn(): Channel
    {
        return new Channel('accommodation.' . $this->accommodationId);
    }

    public function broadcastAs(): string
    {
        return 'availability.changed';
    }
}