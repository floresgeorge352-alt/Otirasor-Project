<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExtraShiftRequest extends Model
{
    protected $fillable = [
        'employee_id',
        'requested_by',
        'request_type',
        'shift_date',
        'start_time',
        'end_time',
        'reason',
        'employee_response',
        'status',
        'responded_at',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'shift_date' => 'date',
            'responded_at' => 'datetime',
            'confirmed_at' => 'datetime',
        ];
    }

    /**
     * Employee na nakatalaga sa extra shift.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    /**
     * User na gumawa ng request.
     * Puwedeng admin o employee.
     */
    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_by');
    }
}