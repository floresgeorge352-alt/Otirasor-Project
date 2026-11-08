<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'regular_time_in',
        'regular_time_out',
        'unpaid_break_minutes',
        'grace_period_minutes',
        'work_days',
        'reward_points',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'work_days' => 'array',
        ];
    }

    // =========================================================
    // RELATIONSHIPS
    // =========================================================

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function rewardPoints(): HasMany
    {
        return $this->hasMany(RewardPoint::class);
    }
}