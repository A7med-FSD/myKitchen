<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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
    Route::get('/menu' , 'menu')->name('user.menu');
    Route::get('/orders' , 'orders')->name('user.orders');
    Route::get('/offers' , 'offers')->name('user.offers');
    Route::get('/profile' , 'profile')->name('user.profile');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/login' , 'showLogin')->name('user.login');
    // Route::post('/login' , 'login')->name('user.login');
    Route::get('/register' , 'showRegister')->name('user.register');
    // Route::post('/register' , 'register')->name('user.register');
});

// Admin routes
Route::controller(AuthController::class)->prefix('/admin')->group(function () {
    Route::get('/login', 'showAdminLogin')->name('admin.login');
    Route::post('/login', 'adminLogin');
});

Route::view('/' , 'landing_page');