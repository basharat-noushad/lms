<?php

namespace Tests\Feature\Public;

use App\Livewire\Public\Courses\Index;
use App\Livewire\Public\Courses\Show;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_course_catalog_renders_correctly()
    {
        $this->get(route('courses.index'))
            ->assertStatus(200)
            ->assertSeeLivewire(Index::class);
    }

    public function test_course_catalog_displays_published_courses()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();
        
        $course = Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'published',
            'title' => 'Public Course'
        ]);

        $draftCourse = Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'draft',
            'title' => 'Draft Course'
        ]);

        $this->get(route('courses.index'))
            ->assertSee('Public Course')
            ->assertDontSee('Draft Course');
    }

    public function test_course_catalog_search_functionality()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();
        
        Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'published',
            'title' => 'Laravel Mastery'
        ]);

        Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'published',
            'title' => 'React Basics'
        ]);

        Livewire::test(Index::class)
            ->set('search', 'Laravel')
            ->assertSee('Laravel Mastery')
            ->assertDontSee('React Basics');
    }

    public function test_course_detail_page_renders_correctly()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();
        
        $course = Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'published',
            'title' => 'Detail Course'
        ]);

        $this->get(route('courses.show', $course))
            ->assertStatus(200)
            ->assertSeeLivewire(Show::class)
            ->assertSee('Detail Course');
    }

    public function test_course_detail_page_returns_404_for_unpublished_courses()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();
        
        $course = Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'draft',
        ]);

        $this->get(route('courses.show', $course))
            ->assertStatus(404);
    }
}
