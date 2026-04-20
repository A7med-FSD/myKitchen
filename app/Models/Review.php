<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'user_id',
        'dish_id',
        'rating',
        'content',
        'is_published',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the user who wrote this review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dish(): BelongsTo {
        return $this->belongsTo(Dish::class);
    }
}
