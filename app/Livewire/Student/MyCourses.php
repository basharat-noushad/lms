<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class MyCourses extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, in-progress, completed
    public $sortBy = 'recent'; // recent, title, progress

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingSortBy()
    {
        $this->resetPage();
    }

    public function getCourses()
    {
        $query = Auth::user()->enrollments()->with(['course.instructor', 'course.category']);

        // Apply search
        if ($this->search) {
            $query->whereHas('course', function($q) {
                $q->where('title', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filter
        switch ($this->filter) {
            case 'in-progress':
                $query->where('progress', '>', 0)->where('progress', '<', 100);
                break;
            case 'completed':
                $query->where('progress', 100);
                break;
        }

        // Apply sorting
        switch ($this->sortBy) {
            case 'title':
                $query->join('courses', 'enrollments.course_id', '=', 'courses.id')
                      ->orderBy('courses.title');
                break;
            case 'progress':
                $query->orderBy('progress', 'desc');
                break;
            default: // recent
                $query->latest();
                break;
        }

        return $query->paginate(9);
    }

    public function render()
    {
        return view('livewire.student.my-courses', [
            'enrollments' => $this->getCourses(),
        ])->layout('layouts.student');
    }
}
