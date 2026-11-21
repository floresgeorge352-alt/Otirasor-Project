<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'contact_number',
        'number_of_guests',
        'number_of_adults',
        'number_of_kids',
        'check_in',
        'check_out',
        'payment_method',
        'gcash_reference',
        'gcash_proof',
        'payment_status',
        'payment_rejection_reason',
        'accommodation_total',
        'facility_total',

        // Entrance and Swimming Fee Rates
        'entrance_adult_rate',
        'entrance_child_rate',
        'swimming_adult_rate',
        'swimming_child_rate',

        // Swimming Pool Guest Counts
        'pool_adults',
        'pool_kids',

        'status',
        'rejection_reason',

        // Cancellation fields
        'cancellation_requested_at',
        'cancellation_reason',
        'cancellation_status',

        // Electronic receipt fields
        'receipt_number',
        'receipt_generated_at',

        // Promo / discount
        'promo_code',
        'discount_amount',

        // Rewards
        'reward_points_used',
        'reward_discount',

        // Refund fields
        'refund_status',
        'refund_notes',
        'refund_request_reason',
        'refunded_at',
        'refund_reference',
        'refund_message',
        'refund_proof',
    ];

    protected $casts = [
        'cancellation_requested_at' => 'datetime',
        'receipt_generated_at' => 'datetime',
        'refunded_at' => 'datetime',

        'accommodation_total' => 'decimal:2',
        'facility_total' => 'decimal:2',

        // Entrance and Swimming Fee Rates
        'entrance_adult_rate' => 'decimal:2',
        'entrance_child_rate' => 'decimal:2',
        'swimming_adult_rate' => 'decimal:2',
        'swimming_child_rate' => 'decimal:2',

        'pool_adults' => 'integer',
        'pool_kids' => 'integer',

        'discount_amount' => 'decimal:2',

        // Rewards
        'reward_points_used' => 'integer',
        'reward_discount' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function accommodations(): BelongsToMany
    {
        return $this->belongsToMany(
            Accommodation::class,
            'booking_accommodation',
            'booking_id',
            'accommodation_id'
        )
            ->withPivot('price_at_booking')
            ->withTimestamps();
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    // Payment Logs Relationship
    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class)->latest();
    }

    // Net Total Accessor
    /**
     * Compute the net total after discount and reward discount.
     * Formula: (accommodation_total + facility_total)
     *          - discount_amount - reward_discount
     */
    public function getNetTotalAttribute(): float
    {
        $subtotal = (float) ($this->accommodation_total ?? 0)
                  + (float) ($this->facility_total ?? 0);

        $discount = (float) ($this->discount_amount ?? 0);
        $rewardDiscount = (float) ($this->reward_discount ?? 0);

        return $subtotal - $discount - $rewardDiscount;
    }

    // Accommodations Accessor (Legacy Support)
    /**
     * Fallback accessor para sa accommodations attribute.
     * Kung may laman ang pivot table, doon kukuha.
     * Kung wala, ibabalik ang lumang comma-separated string.
     */
    public function getAccommodationsAttribute($value)
    {
        // 1. Check if relationship is already loaded
        if ($this->relationLoaded('accommodations')) {
            $names = $this->relations['accommodations']->pluck('name')->toArray();

            if (!empty($names)) {
                return implode(', ', $names);
            }
        }

        // 2. Check if may laman ang pivot table
        if ($this->accommodations()->exists()) {
            $names = $this->accommodations()->pluck('name')->toArray();

            if (!empty($names)) {
                return implode(', ', $names);
            }
        }

        // 3. Fallback sa lumang string column
        return $value;
    }
}
