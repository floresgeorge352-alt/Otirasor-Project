<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReviewCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Review $review) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('public.reviews'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->review->id,
            'user_name' => $this->review->user->name ?? 'Guest',
            'rating' => $this->review->rating,
            'comment' => $this->review->comment,
            'created_at' => $this->review->created_at->diffForHumans(),
        ];
    }
}