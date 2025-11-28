<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Public\Home::class)->name('home');
Route::get('/courses', \App\Livewire\Public\Courses\Index::class)->name('courses.index');
Route::get('/courses/{course:slug}', \App\Livewire\Public\Courses\Show::class)->name('courses.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout/{course}', [\App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/callback/{order}', [\App\Http\Controllers\CheckoutController::class, 'callback'])->name('checkout.callback');
    Route::get('/checkout/cancel', [\App\Http\Controllers\CheckoutController::class, 'cancel'])->name('checkout.cancel');
    Route::get('/checkout/success', [\App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
});

// Webhook routes (no CSRF protection needed)
Route::post('/webhooks/stripe', [\App\Http\Controllers\WebhookController::class, 'stripe'])->name('webhooks.stripe');
Route::post('/webhooks/razorpay', [\App\Http\Controllers\WebhookController::class, 'razorpay'])->name('webhooks.razorpay');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
