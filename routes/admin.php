<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');
    Route::get('/users/create', \App\Livewire\Admin\Users\Create::class)->name('users.create');
    Route::get('/users/{user}/edit', \App\Livewire\Admin\Users\Edit::class)->name('users.edit');

    // Category Management
    Route::get('/orders/{order}', \App\Livewire\Admin\Orders\Show::class)->name('orders.show');

    // Coupon Management
    Route::get('/coupons', \App\Livewire\Admin\Coupons\Index::class)->name('coupons.index');
    Route::get('/coupons/create', \App\Livewire\Admin\Coupons\Form::class)->name('coupons.create');
    Route::get('/coupons/{coupon}/edit', \App\Livewire\Admin\Coupons\Form::class)->name('coupons.edit');

    // Reports
    Route::get('/reports', \App\Livewire\Admin\Reports\Index::class)->name('reports.index');
});
