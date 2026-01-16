<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;

Route::controller(OwnerController::class)->prefix('/owner')->group(function () {
    Route::get('/', 'dashboard')->name('owner.dashboard');
    Route::get('/orders', 'orders')->name('owner.orders');
    Route::get('/menu', 'menu')->name('owner.menu');
    Route::get('/inventory', 'inventory')->name('owner.inventory');
    Route::get('/analytics', 'analytics')->name('owner.analytics');
    Route::get('/customers', 'customers')->name('owner.customers');
    Route::get('/settings', 'settings')->name('owner.settings');
    Route::get('/notifications', 'notifications')->name('owner.notifications');
    Route::get('/promotions', 'promotions')->name('owner.promotions');
});

Route::controller(UserController::class)->group(function () {
});

Route::view('/' , 'landing_page');