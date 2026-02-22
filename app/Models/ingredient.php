<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'price_per_unit',
        'low_stock_alert'
    ];


}
