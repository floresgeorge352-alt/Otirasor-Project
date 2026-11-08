<?php

namespace App\Events;

use App\Models\Gallery;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GalleryImageAdded implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Gallery $gallery) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('public.gallery'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->gallery->id,
            'title' => $this->gallery->title ?? 'Untitled',
            'image_path' => $this->gallery->image ?? $this->gallery->image_path ?? null,
            'category' => $this->gallery->category ?? 'general',
        ];
    }
}