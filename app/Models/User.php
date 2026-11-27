<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

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
        'phone',
        'avatar',
        'email_notifications',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'password' => 'hashed',
            'work_days' => 'array',
            'email_notifications' => 'boolean',
        ];
    }

    /**
     * Customer bookings.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Customer reward points history.
     */
    public function rewardPoints(): HasMany
    {
        return $this->hasMany(RewardPoint::class);
    }
}