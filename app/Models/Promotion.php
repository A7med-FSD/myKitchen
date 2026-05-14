<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'apply_to',
        'promo_code',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $casts = [
        'value' => 'integer',
        'count_usage' => 'integer',
        'is_active' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Get the orders that used this promotion.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The dishes this promotion applies to.
     */
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class);
    }

    /**
     * The categories this promotion applies to.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Check if promotion is currently active.
     */

    public function scopeActive($query) {
        return $query->where('is_active', true)
                ->where('start_date', "<=" , now())
                ->where('end_date', ">=", now());
    }
}
