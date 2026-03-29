<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

// Start auth apis

Route::prefix("auth")->controller(AuthController::class)->group(function () {
    Route::post("{type}/login", "login")->whereIn('type', ['owner', 'user', '']);
    Route::post("register", "register");
});

// End auth apis 


// Start dishes apis 

// all users 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-popular', 'mostPopularDishes'); // for landing page

    Route::middleware('auth:customer')->group(function () {
        Route::get('/most-ordered', 'mostOrderdDishes'); 
        Route::get('/', 'dishes');
    });
});

// owner
Route::middleware('auth:owner')->prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// End dishes apis 


// Start orders apis 

// all users 
Route::middleware('auth:customer')->prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/{userId}', 'orders');
    Route::post('/', 'placeOrder');
});

// owner
Route::middleware('auth:owner')->prefix('owner/orders')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index');
    Route::patch('/{orderId}', 'updateStatus');
});

// End orders apis 

// Start category apis

// all users
Route::middleware('auth:customer')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
});

// owner
Route::middleware('auth:owner')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::post('/', 'store');
    Route::delete('/{category_id}', 'delete');
});
// End category apis


// Start promotion apis

// all users
Route::middleware('auth:customer')->prefix('promotions')->controller(PromotionController::class)->group(function () {
    Route::get('/{apply_to}', 'activePromotions');
});

// owner
Route::middleware('auth:owner')->prefix('owner/promotions')->controller(PromotionController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::patch('/{promotion}', 'update');
    Route::delete('/{promotion_id}', 'delete');
});
// End promotion apis