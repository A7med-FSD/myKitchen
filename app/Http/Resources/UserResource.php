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
            'googleMap_link' => $this->address_link,
            'status' => $this->status,
            'orders_count' => $this->when(isset($this->orders_count), function () {
                return $this->orders_count;
            }),
            'favorite_category' => $this->when(isset($this->favorite_category), function () {
                return $this->favorite_category;
            }),
            'last_order' => $this->when(isset($this->last_order), function () {
                return $this->last_order;
            })
        ];
    }
}
