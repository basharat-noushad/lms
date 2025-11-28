<?php

namespace App\Livewire\Admin\Courses;

use App\Models\Course;
use Livewire\Component;

class Show extends Component
{
    public Course $course;
    public $rejectionReason = '';
    public $showRejectModal = false;

    public function mount(Course $course)
    {
        $this->course = $course->load(['instructor', 'category', 'sections.lessons']);
    }

    public function approve()
    {
        $this->course->update([
            'status' => 'published',
            'published_at' => now(),
        ]);

        // TODO: Send notification to instructor

        session()->flash('message', 'Course approved and published successfully.');
    }

    public function openRejectModal()
    {
        $this->showRejectModal = true;
    }

    public function reject()
    {
        $this->validate([
            'rejectionReason' => 'required|string|min:10',
        ]);

        $this->course->update([
            'status' => 'rejected',
            // Store rejection reason if we had a field, or send via email
        ]);

        // TODO: Send notification with reason

        $this->showRejectModal = false;
        session()->flash('message', 'Course rejected.');
    }

    public function render()
    {
        return view('livewire.admin.courses.show');
    }
}
