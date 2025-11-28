<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $enrolledCourses;
    public $completedCourses;
    public $inProgressCourses;
    public $certificates;
    
    public function mount()
    {
        $user = Auth::user();
        
        $this->enrolledCourses = $user->enrollments()
            ->with(['course.instructor', 'course.category'])
            ->latest()
            ->get();
            
        $this->inProgressCourses = $this->enrolledCourses->where('progress', '<', 100)->where('progress', '>', 0);
        $this->completedCourses = $this->enrolledCourses->where('progress', 100);
        $this->certificates = $user->certificates()->with('course')->latest()->get();
    }

    public function render()
    {
        return view('livewire.student.dashboard')
            ->layout('layouts.student');
    }
}
