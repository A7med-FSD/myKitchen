<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_phone' => $this->customer_phone,
            'order_code' => $this->order_code,
            'status' => $this->status,
            'total_price_before_promotion' => $this->total_price_before_promotion,
            'total_price' => $this->total_price,
            'created_at' => $this->created_at,
            'address' => $this->address_text,
            'googleMap_link' => $this->address_link,
            'dishes' => $this->whenLoaded('dishes', function () {
                return $this->dishes->map(function ($dish) {
                    return [
                        'name' => $dish->pivot->dish_name_at_order,
                        'price' => $dish->pivot->dish_price_at_order,
                        'total_price_before_promotion' => $dish->pivot->dish_price_at_order * $dish->pivot->quantity,
                        'quantity' => $dish->pivot->quantity,
                        'total_price_after_promotion' => $dish->total_price,
                        'promotion' => $dish->pivot->promotion_value
                    ];
                });
            }),
        ];
    }
}
