<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    protected $fillable = [
        'customer_phone',
        'customer_name',
        'delivery_notes',
        'address_link',
        'address_text',
        'promo_code',
        'payment_method',
    ];

    protected $casts = [
        'order_code' => 'integer',
        'total_price' => 'integer',
        'promotion_value' => 'integer',
    ];

    /**
     * Get the promotion applied to this order.
     */
    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }

    /**
     * The dishes in this order.
     */
    public function dishes(): BelongsToMany
    {
        return $this->belongsToMany(Dish::class)
                ->withPivot('quantity', 'dish_price_at_order', 'dish_name_at_order', 'promotion_value');
    }

    /**
     * The users associated with this order.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
