<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $status = 'all';

    protected $queryString = ['search', 'status'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function deleteCourse(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }

        if ($course->enrollments()->exists()) {
            session()->flash('error', 'Cannot delete course with active enrollments.');
            return;
        }

        $course->delete();
        session()->flash('message', 'Course deleted successfully.');
    }

    public function render()
    {
        $courses = Course::where('instructor_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== 'all', function ($query) {
                $query->where('status', $this->status);
            })
            ->latest()
            ->paginate(10);

        // \Illuminate\Support\Facades\Log::info('Courses count: ' . $courses->count());
        // \Illuminate\Support\Facades\Log::info('Auth ID: ' . Auth::id());
        // dd('Courses count: ' . $courses->count() . ' Auth ID: ' . Auth::id());
        // throw new \Exception('Auth ID: ' . Auth::id() . ' Count: ' . $courses->count());

        return view('livewire.instructor.courses.index', [
            'courses' => $courses,
        ])->layout('layouts.instructor');
    }
}
