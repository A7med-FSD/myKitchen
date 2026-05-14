<?php

namespace App\Models;

use App\Events\OrderDelivered;
use App\Exceptions\InvalidOrderStatusException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Order extends Model
{
    protected $fillable = [
        'customer_phone',
        'customer_name',
        'delivery_notes',
        'latitude',
        'longitude',
        'address_text',
        'payment_method',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'promotion_value' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8'
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
     * The user who placed this order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    // Domain functions

    private function canUpdate($newStatus): bool {
        return match ($newStatus) {
            "cancelled" => $this->status !== "delivered",
            "in_progress" => $this->status === "pending",
            "ready" => $this->status === "in_progress",
            "delivered" => $this->status === "ready"
        };
    }


    public function evaluateStatus($newStatus): void {
        if(!$this->canUpdate($newStatus)) {
            throw new InvalidOrderStatusException($this->status, $newStatus);
        }

        $this->status = $newStatus;
        $this->save();
        if($newStatus === "delivered") {
            OrderDelivered::dispatch($this->user_id);
        }
    }

}
