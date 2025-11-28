<?php

namespace Tests\Feature\Instructor;

use App\Models\User;
use App\Models\Course;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Instructor\Courses\Curriculum;

class CurriculumTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_add_section()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $course = Course::factory()->create(['instructor_id' => $instructor->id]);

        Livewire::actingAs($instructor)
            ->test(Curriculum::class, ['course' => $course])
            ->call('openSectionModal')
            ->set('sectionTitle', 'New Section')
            ->call('saveSection');

        $this->assertDatabaseHas('sections', [
            'course_id' => $course->id,
            'title' => 'New Section',
        ]);
    }

    public function test_instructor_can_add_lesson()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $course = Course::factory()->create(['instructor_id' => $instructor->id]);
        $section = Section::factory()->create(['course_id' => $course->id]);

        Livewire::actingAs($instructor)
            ->test(Curriculum::class, ['course' => $course])
            ->call('openLessonModal', $section->id)
            ->set('lessonTitle', 'New Lesson')
            ->set('lessonType', 'video')
            ->set('lessonDuration', 10)
            ->call('saveLesson');

        $this->assertDatabaseHas('lessons', [
            'section_id' => $section->id,
            'title' => 'New Lesson',
        ]);
    }
}
