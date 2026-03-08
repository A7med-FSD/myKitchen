<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// home apis 
// get dishes apis for all users 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-ordered', 'mostOrderdDishes');
    Route::get('/', 'dishes');
    Route::get('/most-popular', 'mostPopularDishes');
});

// get orders apis for all users 
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/{userId}', 'orders');
});

// end home apis

// post dishes apis for owner
Route::prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

