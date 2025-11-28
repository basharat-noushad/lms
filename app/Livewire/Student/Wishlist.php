<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Component
{
    use WithPagination;

    protected $listeners = ['wishlist-updated' => '$refresh'];

    public function removeFromWishlist($courseId)
    {
        Auth::user()->wishlists()->where('course_id', $courseId)->delete();
        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        $wishlistItems = Auth::user()->wishlists()
            ->with(['course.instructor', 'course.category'])
            ->latest()
            ->paginate(12);

        return view('livewire.student.wishlist', [
            'wishlistItems' => $wishlistItems
        ])->layout('layouts.student');
    }
}
