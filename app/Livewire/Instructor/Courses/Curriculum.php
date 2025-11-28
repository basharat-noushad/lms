<?php

namespace App\Livewire\Instructor\Courses;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Curriculum extends Component
{
    public Course $course;
    
    // Modal States
    public $showSectionModal = false;
    public $showLessonModal = false;
    public $isEditing = false;

    // Section Form
    public $sectionId;
    public $sectionTitle;

    // Lesson Form
    public $lessonId;
    public $currentSectionId;
    public $lessonTitle;
    public $lessonType = 'video';
    public $lessonContent; // URL for video, text content for text
    public $lessonDuration;
    public $isFreePreview = false;

    public function mount(Course $course)
    {
        if ($course->instructor_id !== Auth::id()) {
            abort(403);
        }
        $this->course = $course;
    }

    // Section Management
    public function openSectionModal($id = null)
    {
        $this->reset(['sectionId', 'sectionTitle']);
        $this->isEditing = false;

        if ($id) {
            $section = Section::find($id);
            $this->sectionId = $section->id;
            $this->sectionTitle = $section->title;
            $this->isEditing = true;
        }

        $this->showSectionModal = true;
    }

    public function saveSection()
    {
        $this->validate([
            'sectionTitle' => 'required|string|max:255',
        ]);

        if ($this->isEditing) {
            Section::find($this->sectionId)->update([
                'title' => $this->sectionTitle,
            ]);
        } else {
            $this->course->sections()->create([
                'title' => $this->sectionTitle,
                'sort_order' => $this->course->sections()->max('sort_order') + 1,
            ]);
        }

        $this->showSectionModal = false;
        $this->reset(['sectionId', 'sectionTitle']);
        session()->flash('message', 'Section saved successfully.');
    }

    public function deleteSection($id)
    {
        $section = Section::find($id);
        if ($section->lessons()->exists()) {
            session()->flash('error', 'Cannot delete section with lessons. Delete lessons first.');
            return;
        }
        $section->delete();
        session()->flash('message', 'Section deleted successfully.');
    }

    public function updateSectionOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Section::where('id', $id)->update(['sort_order' => $index + 1]);
        }
    }

    // Lesson Management
    public function openLessonModal($sectionId, $lessonId = null)
    {
        $this->reset(['lessonId', 'lessonTitle', 'lessonType', 'lessonContent', 'lessonDuration', 'isFreePreview']);
        $this->currentSectionId = $sectionId;
        $this->isEditing = false;

        if ($lessonId) {
            $lesson = Lesson::find($lessonId);
            $this->lessonId = $lesson->id;
            $this->lessonTitle = $lesson->title;
            $this->lessonType = $lesson->type;
            $this->lessonContent = $lesson->content; // Or url depending on type
            $this->lessonDuration = $lesson->duration;
            $this->isFreePreview = $lesson->is_free_preview;
            $this->isEditing = true;
        }

        $this->showLessonModal = true;
    }

    public function saveLesson()
    {
        $this->validate([
            'lessonTitle' => 'required|string|max:255',
            'lessonType' => 'required|in:video,text',
            'lessonContent' => 'required|string', // URL or Text
            'lessonDuration' => 'nullable|integer',
            'isFreePreview' => 'boolean',
        ]);

        $data = [
            'section_id' => $this->currentSectionId,
            'title' => $this->lessonTitle,
            'type' => $this->lessonType,
            'content' => $this->lessonContent, // For video this is URL, for text this is content
            'duration' => $this->lessonDuration ?? 0,
            'is_free_preview' => $this->isFreePreview,
        ];

        if ($this->isEditing) {
            Lesson::find($this->lessonId)->update($data);
        } else {
            $section = Section::find($this->currentSectionId);
            $data['sort_order'] = $section->lessons()->max('sort_order') + 1;
            $section->lessons()->create($data);
        }

        $this->showLessonModal = false;
        $this->reset(['lessonId', 'lessonTitle', 'lessonType', 'lessonContent', 'lessonDuration', 'isFreePreview']);
        session()->flash('message', 'Lesson saved successfully.');
    }

    public function deleteLesson($id)
    {
        Lesson::find($id)->delete();
        session()->flash('message', 'Lesson deleted successfully.');
    }

    public function updateLessonOrder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            Lesson::where('id', $id)->update(['sort_order' => $index + 1]);
        }
    }

    public function render()
    {
        return view('livewire.instructor.courses.curriculum', [
            'sections' => $this->course->sections()->with(['lessons' => function($query) {
                $query->orderBy('sort_order');
            }])->orderBy('sort_order')->get(),
        ])->layout('layouts.instructor');
    }
}
