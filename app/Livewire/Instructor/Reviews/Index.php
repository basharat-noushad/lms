<?php

namespace App\Livewire\Instructor\Reviews;

use App\Models\Course;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $rating = 'all';

    public function updatingRating()
    {
        $this->resetPage();
    }

    public function render()
    {
        $instructorId = Auth::id();
        $courseIds = Course::where('instructor_id', $instructorId)->pluck('id');

        $reviews = Review::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->when($this->rating !== 'all', function ($query) {
                $query->where('rating', $this->rating);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.instructor.reviews.index', [
            'reviews' => $reviews,
        ])->layout('layouts.instructor');
    }
}
