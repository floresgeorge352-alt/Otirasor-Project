<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Accommodation extends Model
{
    protected $fillable = [
        'name',
        'type',
        'room_type',
        'description',
        'amenities',
        'price',
        'capacity',
        'image',
        'status',
        'maintenance_start',
        'maintenance_end',
        'maintenance_reason',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'capacity' => 'integer',
        'amenities' => 'array',
        'maintenance_start' => 'date',
        'maintenance_end' => 'date',
    ];

    /**
     * Bookings that include this accommodation (many-to-many).
     */
    public function bookings(): BelongsToMany
    {
        return $this->belongsToMany(
            Booking::class,
            'booking_accommodation',
            'accommodation_id',
            'booking_id'
        )
            ->withPivot('price_at_booking')
            ->withTimestamps();
    }
}