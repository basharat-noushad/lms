<?php

namespace Tests\Feature\Instructor;

use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Livewire\Livewire;
use App\Livewire\Instructor\Dashboard;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_instructor_can_access_dashboard()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);

        $this->actingAs($instructor)
            ->get(route('instructor.dashboard'))
            ->assertStatus(200);
    }

    public function test_student_cannot_access_dashboard()
    {
        $student = User::factory()->create(['role' => 'student']);

        $this->actingAs($student)
            ->get(route('instructor.dashboard'))
            ->assertStatus(403);
    }

    public function test_dashboard_stats_are_displayed_correctly()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        
        // Create some data
        $course = Course::factory()->create(['instructor_id' => $instructor->id]);
        Enrollment::factory()->count(5)->create(['course_id' => $course->id]);
        Review::factory()->count(3)->create(['course_id' => $course->id, 'rating' => 5]);

        Livewire::actingAs($instructor)
            ->test(Dashboard::class)
            ->assertSee($course->title)
            ->assertSee('5') // Enrollments
            ->assertSee('5.0'); // Rating
    }

    public function test_layout_renders()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $this->actingAs($instructor);
        $view = $this->view('layouts.instructor');
        $view->assertSee('Instructor');
    }
}
