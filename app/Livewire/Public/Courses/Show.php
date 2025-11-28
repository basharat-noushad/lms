<?php

namespace App\Livewire\Public\Courses;

use App\Models\Course;
use Livewire\Component;

class Show extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        if ($course->status !== 'approved') {
            abort(404);
        }
        
        $this->course = $course->load(['instructor', 'category', 'sections.lessons', 'reviews.user']);
    }

    public function render()
    {
        return view('livewire.public.courses.show')->layout('layouts.public');
    }
}
