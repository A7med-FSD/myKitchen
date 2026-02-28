<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DishResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'category' => $this->whenLoaded('category', function () {
                return $this->category->name;
            }),
            'rate' => $this->rate,
            'time_preparing' => $this->time_preparing,
            'count' => $this->when(isset($this->orders_count), function () {
                return $this->orders_count;
            }),
            'promotion' => $this->whenLoaded('activePromotion', function () {
                return $this->activePromotion->first()?->value;
            }),
            'badge' => $this->badge,
            'is_available' => $this->is_available,
        ];
    }
}
