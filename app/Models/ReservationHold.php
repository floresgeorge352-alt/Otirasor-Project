<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ReservationHold extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'accommodation_ids',
        'check_in',
        'check_out',
        'expires_at',
        'released_at',
    ];

    protected $casts = [
        'accommodation_ids' => 'array',
        'check_in' => 'date',
        'check_out' => 'date',
        'expires_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isActive(): bool
    {
        return is_null($this->released_at) && $this->expires_at->isFuture();
    }

    public function scopeActive($query)
    {
        return $query->whereNull('released_at')
            ->where('expires_at', '>', now());
    }

    public static function holdDurationMinutes(): int
    {
        return 15;
    }

    public static function expireStale(): int
    {
        return static::whereNull('released_at')
            ->where('expires_at', '<=', now())
            ->update(['released_at' => now()]);
    }
}