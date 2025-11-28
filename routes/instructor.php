<?php

use Illuminate\Support\Facades\Route;
Route::middleware(['auth', 'verified', 'instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', \App\Livewire\Instructor\Dashboard::class)->name('dashboard');
    
    // Course Management
    Route::get('/courses', \App\Livewire\Instructor\Courses\Index::class)->name('courses.index');
    Route::get('/courses/create', \App\Livewire\Instructor\Courses\Create::class)->name('courses.create');
    Route::get('/courses/{course}/edit', \App\Livewire\Instructor\Courses\Edit::class)->name('courses.edit');
    Route::get('/courses/{course}/curriculum', \App\Livewire\Instructor\Courses\Curriculum::class)->name('courses.curriculum');
    Route::get('/courses/{course}/sections/{section}/quiz/{quiz?}', \App\Livewire\Instructor\QuizBuilder::class)->name('courses.quiz.builder');
    
    // Student Management
    Route::get('/students', \App\Livewire\Instructor\Students\Index::class)->name('students.index');
    
    // Review Management
    
    // Earnings & Withdrawals
    Route::get('/earnings', \App\Livewire\Instructor\Earnings\Index::class)->name('earnings.index');
    Route::get('/withdrawals', \App\Livewire\Instructor\Withdrawals\Index::class)->name('withdrawals.index');
    
    // Coupons
    Route::get('/coupons', \App\Livewire\Instructor\Coupons\Index::class)->name('coupons.index');
    Route::get('/coupons/create', \App\Livewire\Instructor\Coupons\Create::class)->name('coupons.create');
});
