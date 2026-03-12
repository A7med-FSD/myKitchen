<?php

use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Start dishes apis 

// all users 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-ordered', 'mostOrderdDishes');
    Route::get('/', 'dishes');
    Route::get('/most-popular', 'mostPopularDishes');
});

// owner
Route::prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// End dishes apis 


// Start orders apis 

// all users 
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/{userId}', 'orders');
    Route::post('/', 'placeOrder');
});

// owner
Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::patch('/{orderId}' , 'updateStatus');
});

// End orders apis 

// Start category apis

// all users
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/' , 'index');
});

// owner
Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::post('/' , 'store');
    Route::delete('/{category_id}', 'delete');
});
// End category apis