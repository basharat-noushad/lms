<?php

namespace Tests\Feature\Instructor;

use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Instructor\Courses\Index;
use App\Livewire\Instructor\Courses\Create;
use App\Livewire\Instructor\Courses\Edit;
use Illuminate\Http\UploadedFile;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_view_courses()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $course = Course::factory()->create(['instructor_id' => $instructor->id]);

        $response = $this->actingAs($instructor)
            ->get(route('instructor.courses.index'));

        if ($response->status() !== 200) {
             file_put_contents('d:\Code\lms\error_log.txt', $response->content());
        }

        $response->assertStatus(200);
        $response->assertSee($course->title);
    }

    public function test_instructor_can_create_course()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();

        Livewire::actingAs($instructor)
            ->test(Create::class)
            // dd(function_exists('format_currency'));
            ->set('title', 'New Course')
            ->set('slug', 'new-course')
            ->set('category_id', $category->id)
            ->set('level', 'beginner')
            ->set('short_description', 'Short description')
            ->call('nextStep') // To Details
            ->set('description', 'Long description')
            ->set('requirements', 'Requirements')
            ->set('outcomes', 'Outcomes')
            ->call('nextStep') // To Media
            ->set('thumbnail', UploadedFile::fake()->image('thumb.jpg'))
            ->call('nextStep') // To Pricing
            ->set('price', 100)
            ->call('save');

        $this->assertDatabaseHas('courses', [
            'title' => 'New Course',
            'instructor_id' => $instructor->id,
        ]);
    }

    public function test_instructor_can_edit_course()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $course = Course::factory()->create(['instructor_id' => $instructor->id]);

        Livewire::actingAs($instructor)
            ->test(Edit::class, ['course' => $course])
            ->set('title', 'Updated Course Title')
            ->call('save');

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'title' => 'Updated Course Title',
        ]);
    }
}
