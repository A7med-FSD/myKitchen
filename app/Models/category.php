<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Category extends Model
{
    protected $fillable = [
        'name',
        'emoji',
    ];

    /**
     * Get the dishes for this category.
     */
    public function dishes(): HasMany
    {
        return $this->hasMany(Dish::class);
    }

    /**
     * The promotions applied to this category.
     */
    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function activePromotion()
    {
        return $this->belongsToMany(Promotion::class)
            ->where('promotions.is_active', true)
            ->where('promotions.start_date', '<=', Carbon::now())
            ->where('promotions.end_date', '>=', Carbon::now())
            ->latest('promotions.created_at')
            ->limit(1);
    }
}
