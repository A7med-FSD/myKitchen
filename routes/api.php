<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IngredientController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Start auth apis

Route::prefix("auth")->controller(AuthController::class)->group(function () {
    Route::post("{type}/login", "login")->whereIn('type', ['owner', 'user', '']);
    Route::post("register", "register");
    Route::post('logout', 'logout')->middleware('auth:customer');
    Route::post('owner/logout', 'logout')->middleware('auth:owner');
});

// End auth apis 

// Start dishes apis 

// customers 
Route::prefix('dishes')->controller(DishController::class)->group(function () {
    Route::get('/most-popular', 'mostPopularDishes'); // for landing page

    Route::middleware('auth:customer')->group(function () {
        Route::get('/most-ordered', 'mostOrderedDishes'); 
        Route::get('/', 'index');
    });
});

// owner
Route::middleware('auth:owner')->prefix('owner/dishes')->controller(DishController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::patch('/{id}', 'update');
    Route::delete('/{id}', 'destroy');
});

// End dishes apis 

// Start orders apis 

// customers 
Route::middleware('auth:customer')->prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/', 'orders');
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
Route::middleware('auth:customer,owner')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index');
});

// owner
Route::middleware('auth:owner')->prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::post('/', 'store');
    Route::delete('/{category_id}', 'delete');
});
// End category apis

// Start promotion apis

// customers
Route::middleware('auth:customer')->prefix('promotions')->controller(PromotionController::class)->group(function () {
    Route::get('/{apply_to}', 'activePromotions');
});

// owner
Route::middleware('auth:owner')->prefix('owner/promotions')->controller(PromotionController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::patch('/{promotion}', 'update');
    Route::delete('/{promotion_id}', 'destroy');
});

// End promotion apis

// Start review apis

// all user
Route::post('review', [ReviewController::class, 'store'])->middleware('auth:customer');
Route::get('review', [ReviewController::class, 'index'])->middleware('auth:customer,owner');

// owner
Route::post('reviewUpdate/{reviewId}', [ReviewController::class, 'togglePublish'])->middleware('auth:owner');

// End review apis

// Start ingredient apis

Route::middleware('auth:owner')->prefix('ingredients')->controller(IngredientController::class)->group(function () {
    Route::get('', 'index');
    Route::post('', 'store');
    Route::patch('/{ingredientId}', 'update');
    Route::delete('/{ingredientId}', 'destroy');
});

// End ingredient apis

// Start user apis

Route::middleware('auth:customer')->prefix('user')->controller(UserController::class)->group(function () {
    Route::get('/profile', 'profile');
    Route::patch('/profile', 'update');
});

// End user apis

// Start setting apis for Owner only 

Route::middleware('auth:owner')->patch('owner/setting', [SettingController::class, 'update']);

// End  etting apis