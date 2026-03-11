<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

// Start dishes apis 

// dishes apis for all users 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-ordered', 'mostOrderdDishes');
    Route::get('/', 'dishes');
    Route::get('/most-popular', 'mostPopularDishes');
});

// dishes apis for owner
Route::prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// End dishes apis 


// Start orders apis 

// orders apis for all users 
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/{userId}', 'orders');
    Route::post('/', 'placeOrder');
});

// orders apis for owner
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::patch('/{orderId}' , 'updateStatus');
});

// End orders apis 


