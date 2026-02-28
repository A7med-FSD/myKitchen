<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;

// get apis for dishes 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-ordered', 'mostOrderdDishes');
    Route::get('/', 'dishes');
    Route::get('/most-popular', 'mostPopularDishes');
});
