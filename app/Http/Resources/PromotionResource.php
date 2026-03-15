<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PromotionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'promo_code' => $this->when($this->promo_code, $this->promo_code),
            'value' => $this->value,
            'end_date' => $this->end_date,
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'name' => $category->name,
                        'emoji' => $category->emoji
                    ];    
                });
            }),
            'dishes' => $this->whenLoaded('dishes', function () {
                return $this->dishes->map(function ($dish) {
                    return [
                        'image' => $dish->image,
                        'name' => $dish->name,
                        'price' => $dish->price
                    ];
                }); 
            })
        ];
    }
}
