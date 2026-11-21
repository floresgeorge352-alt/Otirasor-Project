<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeHistory extends Model
{
    protected $fillable = [
        'fee_id', 'user_id', 'action',
        'old_amount', 'new_amount', 'changes', 'ip_address',
    ];

    protected $casts = [
        'changes'    => 'array',
        'old_amount' => 'decimal:2',
        'new_amount' => 'decimal:2',
    ];

    public function fee(): BelongsTo
    {
        return $this->belongsTo(Fee::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}