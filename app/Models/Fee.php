<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fee extends Model
{
    protected $fillable = [
        'name', 'type', 'applies_to', 'amount', 'is_active',
    ];

    protected $casts = [
        'amount'    => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(FeeHistory::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Compute total per-head fees.
     * Usage: Fee::totalPerHead($adults, $children)
     */
    public static function totalPerHead(int $adults = 0, int $children = 0): float
    {
        $adultEntrance = static::active()->ofType('entrance')->whereIn('applies_to', ['adult', 'all'])->sum('amount');
        $adultSwimming = static::active()->ofType('swimming')->whereIn('applies_to', ['adult', 'all'])->sum('amount');
        $childEntrance = static::active()->ofType('entrance')->whereIn('applies_to', ['child', 'all'])->sum('amount');
        $childSwimming = static::active()->ofType('swimming')->whereIn('applies_to', ['child', 'all'])->sum('amount');

        return (float) (($adults * ($adultEntrance + $adultSwimming)) + ($children * ($childEntrance + $childSwimming)));
    }
}