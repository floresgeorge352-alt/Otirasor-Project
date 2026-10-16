<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'time_in',
        'time_out',
        'status',
        'late_minutes',
        'undertime_minutes',
        'overtime_minutes',
        'overtime_status',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime:H:i',
        'time_out' => 'datetime:H:i',
        'late_minutes' => 'integer',
        'undertime_minutes' => 'integer',
        'overtime_minutes' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}