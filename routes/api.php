<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DishController;

// get dishes apis for all users 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-ordered', 'mostOrderdDishes');
    Route::get('/', 'dishes');
    Route::get('/most-popular', 'mostPopularDishes');
});

// post dishes apis for owner
Route::prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
