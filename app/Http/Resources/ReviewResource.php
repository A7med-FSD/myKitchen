<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'reviewer_name' => $this->user->name,
            'reviewer_image' => $this->user->image,
            'dish_name' => $this->dish->name,
            'rating' => $this->rating,
            'content' => $this->content,
            'date' => $this->created_at
        ];
    }
}
