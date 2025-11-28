<?php

namespace App\Livewire\Instructor\Students;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $instructorId = Auth::id();
        $courseIds = Course::where('instructor_id', $instructorId)->pluck('id');

        $enrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.instructor.students.index', [
            'enrollments' => $enrollments,
        ])->layout('layouts.instructor');
    }
}
