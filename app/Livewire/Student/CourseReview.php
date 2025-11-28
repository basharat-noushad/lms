<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CourseReview extends Component
{
    public $course;
    public $rating = 5;
    public $comment = '';
    public $existingReview;

    protected $rules = [
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string|max:1000',
    ];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->existingReview = Review::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        if ($this->existingReview) {
            $this->rating = $this->existingReview->rating;
            $this->comment = $this->existingReview->comment;
        }
    }

    public function save()
    {
        $this->validate();

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'course_id' => $this->course->id,
            ],
            [
                'rating' => $this->rating,
                'comment' => $this->comment,
            ]
        );

        $this->existingReview = Review::where('user_id', Auth::id())
            ->where('course_id', $this->course->id)
            ->first();

        session()->flash('message', 'Review submitted successfully!');
        
        // Optional: Emit event to update parent components if needed
        $this->dispatch('review-updated');
    }

    public function render()
    {
        return view('livewire.student.course-review');
    }
}
