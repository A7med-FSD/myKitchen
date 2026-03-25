<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Carbon\Carbon;

class Dish extends Model
{
    protected $fillable = [
        'name',
        'image',
        'description',
        'time_preparing',
        'price',
        'badge',
        'is_available',
        'category_id',
    ];

    protected $casts = [
        'price' => 'integer',
        'time_preparing' => 'integer',
        'rate' => 'decimal:1',
        'is_available' => 'boolean',
    ];

    /**
     * Get the category that owns the dish.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The orders that contain this dish.
     */
    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('quantity', 'dish_price_at_order', 'dish_name_at_order', 'promotion_value');
    }

    /**
     * The promotions applied to this dish.
     */
    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class);
    }

    public function activePromotion()
    {
        return $this->belongsToMany(Promotion::class)
            ->where('is_active', true)
            ->where('start_date', '<=', Carbon::now())
            ->where('end_date', '>=', Carbon::now())
            ->latest('created_at')
            ->limit(1);
    }

    public function activeCategoryPromotion() {
        
    }
}
