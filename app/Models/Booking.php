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
    ];

    protected $casts = [
        'cancellation_requested_at' => 'datetime',
        'receipt_generated_at' => 'datetime',
        'refunded_at' => 'datetime',

        'accommodation_total' => 'decimal:2',
        'facility_total' => 'decimal:2',

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

    // =========================================================
    // ✅ ACCESSOR — Net Total (single source of truth)
    // =========================================================
    /**
     * Compute the net total (after discount + reward discount).
     * Formula: (accommodation_total + facility_total) - discount_amount - reward_discount
     *
     * Gamitin ito sa LAHAT ng revenue computations
     * (dashboard, analytics, reports, transactions, payments).
     */
    public function getNetTotalAttribute(): float
    {
        $subtotal = (float) ($this->accommodation_total ?? 0)
                  + (float) ($this->facility_total ?? 0);

        $discount = (float) ($this->discount_amount ?? 0);
        $rewardDiscount = (float) ($this->reward_discount ?? 0);

        return $subtotal - $discount - $rewardDiscount;
    }
}