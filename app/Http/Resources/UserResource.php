<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->image,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_text' => $this->address_text,
            'location' => [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'status' => $this->status,
            'joined_date' => $this->created_at->format('Y-m-d'),
            'total_spend' => $this->when(isset($this->total_spend), $this->total_spend),
            'orders_count' => $this->when(isset($this->orders_count), $this->orders_count),
            'favorite_category' => $this->when(isset($this->favorite_category_name), $this->favorite_category_name),
            'last_order' => $this->when(isset($this->last_order_time), $this->last_order_time)
        ];
    }
}
