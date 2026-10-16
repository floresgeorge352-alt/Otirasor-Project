<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'accommodations',
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
    ];

    protected $casts = [
        'cancellation_requested_at' => 'datetime',
        'receipt_generated_at' => 'datetime',

        'accommodation_total' => 'decimal:2',
        'facility_total' => 'decimal:2',

        'pool_adults' => 'integer',
        'pool_kids' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}