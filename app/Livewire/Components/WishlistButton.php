<?php

namespace App\Livewire\Components;

use App\Models\Course;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $courseId;
    public $inWishlist = false;

    public function mount($courseId)
    {
        $this->courseId = $courseId;
        $this->checkStatus();
    }

    public function checkStatus()
    {
        if (Auth::check()) {
            $this->inWishlist = Auth::user()->wishlists()->where('course_id', $this->courseId)->exists();
        }
    }

    public function toggle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if ($this->inWishlist) {
            Auth::user()->wishlists()->where('course_id', $this->courseId)->delete();
            $this->inWishlist = false;
        } else {
            Auth::user()->wishlists()->create(['course_id' => $this->courseId]);
            $this->inWishlist = true;
        }

        $this->dispatch('wishlist-updated');
    }

    public function render()
    {
        return view('livewire.components.wishlist-button');
    }
}
