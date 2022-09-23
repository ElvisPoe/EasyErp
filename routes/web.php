<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ImagesController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

// Global Routes
Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

// Auth Routes
Route::get('login', [AuthenticatedSessionController::class, 'loginShow'])->name('login')->middleware('guest');
Route::post('login', [AuthenticatedSessionController::class, 'login'])->name('login.store')->middleware('guest');
Route::get('register', [AuthenticatedSessionController::class, 'registerShow'])->name('register')->middleware('guest');
Route::post('register', [AuthenticatedSessionController::class, 'register'])->name('register.store')->middleware('guest');
Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Images
Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*')->name('image');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('orders', OrderController::class);
    Route::put('orders/{order}/restore', [OrderController::class, 'restore'])->name('order.restore');
    Route::resource('customers', CustomerController::class);
    Route::put('customers/{customer}/restore', [CustomerController::class, 'restore'])->name('customer.restore');
    Route::resource('products', ProductController::class);
    Route::put('products/{product}/restore', [ProductController::class, 'restore'])->name('product.restore');
    Route::resource('attributes', AttributeController::class);
    Route::put('attributes/{attribute}/restore', [AttributeController::class, 'restore'])->name('attribute.restore');
    Route::resource('attributeValues', AttributeValueController::class);
    Route::put('attributeValues/{attributeValue}/restore', [AttributeValueController::class, 'restore'])->name('attributeValue.restore');
    Route::resource('categories', CategoryController::class);
    Route::put('categories/{category}/restore', [CategoryController::class, 'restore'])->name('category.restore');
    Route::resource('users', UsersController::class);
    Route::put('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::get('settings', [SettingController::class, 'index'])->name('settings');
    Route::get('reports', [ReportsController::class, 'index'])->name('reports');
});
