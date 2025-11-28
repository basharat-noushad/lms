<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Student\Dashboard::class)->name('dashboard');
    Route::get('/courses', \App\Livewire\Student\MyCourses::class)->name('courses');
    Route::get('/orders', \App\Livewire\Student\OrderHistory::class)->name('orders');
    Route::get('/wishlist', \App\Livewire\Student\Wishlist::class)->name('wishlist');
    Route::get('/notifications', \App\Livewire\Student\Notifications::class)->name('notifications');
    Route::get('/course/{courseId}/play/{lessonId?}', \App\Livewire\Student\CoursePlayer::class)->name('course.player');
    Route::get('/quiz/{quiz}/take', \App\Livewire\Student\QuizTaker::class)->name('quiz.take');
});
