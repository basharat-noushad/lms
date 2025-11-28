<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CoursePlayer extends Component
{
    public $course;
    public $enrollment;
    public $currentLesson;
    public $sections;
    public $progress;

    public function mount($courseId, $lessonId = null)
    {
        $this->course = Course::with(['sections.lessons', 'instructor'])->findOrFail($courseId);
        
        // Check if user is enrolled
        $this->enrollment = Enrollment::where('user_id', Auth::id())
            ->where('course_id', $courseId)
            ->firstOrFail();
            
        $this->sections = $this->course->sections()->with(['lessons'])->orderBy('order')->get();
        
        // Load current lesson or first lesson
        if ($lessonId) {
            $this->currentLesson = Lesson::findOrFail($lessonId);
        } else {
            // Find first uncompleted lesson or first lesson
            $firstIncomplete = $this->findFirstIncompleteLesson();
            $this->currentLesson = $firstIncomplete ?? $this->sections->first()->lessons->first();
        }

        $this->loadLessonProgress();
    }

    protected function findFirstIncompleteLesson()
    {
        foreach ($this->sections as $section) {
            foreach ($section->lessons as $lesson) {
                $progress = LessonProgress::where('enrollment_id', $this->enrollment->id)
                    ->where('lesson_id', $lesson->id)
                    ->first();
                    
                if (!$progress || !$progress->completed) {
                    return $lesson;
                }
            }
        }
        return null;
    }

    protected function loadLessonProgress()
    {
        $this->progress = LessonProgress::firstOrCreate(
            [
                'enrollment_id' => $this->enrollment->id,
                'lesson_id' => $this->currentLesson->id,
            ],
            [
                'completed' => false,
            ]
        );
    }

    public function selectLesson($lessonId)
    {
        $this->currentLesson = Lesson::findOrFail($lessonId);
        $this->loadLessonProgress();
    }

    public function markAsCompleted()
    {
        $this->progress->markAsCompleted();
        $this->enrollment->refresh();
        
        $this->dispatch('lesson-completed');
        
        // Auto-play next lesson
        $this->goToNextLesson();
    }

    public function goToNextLesson()
    {
        $nextLesson = $this->getNextLesson();
        if ($nextLesson) {
            $this->selectLesson($nextLesson->id);
        }
    }

    public function goToPreviousLesson()
    {
        $previousLesson = $this->getPreviousLesson();
        if ($previousLesson) {
            $this->selectLesson($previousLesson->id);
        }
    }

    protected function getNextLesson()
    {
        $found = false;
        foreach ($this->sections as $section) {
            foreach ($section->lessons as $lesson) {
                if ($found) {
                    return $lesson;
                }
                if ($lesson->id == $this->currentLesson->id) {
                    $found = true;
                }
            }
        }
        return null;
    }

    protected function getPreviousLesson()
    {
        $previous = null;
        foreach ($this->sections as $section) {
            foreach ($section->lessons as $lesson) {
                if ($lesson->id == $this->currentLesson->id) {
                    return $previous;
                }
                $previous = $lesson;
            }
        }
        return null;
    }

    public function render()
    {
        return view('livewire.student.course-player')
            ->layout('layouts.student');
    }
}
