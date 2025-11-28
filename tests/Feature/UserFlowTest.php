<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register()
    {
        $this->withoutExceptionHandling();
        
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'role' => 'student',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
    }

    public function test_student_can_view_course_catalog()
    {
        $category = Category::create(['name' => 'Development', 'slug' => 'development']);
        Course::factory()->create([
            'title' => 'Laravel Course',
            'category_id' => $category->id,
            'is_published' => true,
        ]);

        $response = $this->get(route('courses.index'));

        $response->assertStatus(200);
        $response->assertSee('Laravel Course');
    }

    public function test_student_can_enroll_in_free_course()
    {
        $user = User::factory()->create(['role' => 'student']);
        $category = Category::create(['name' => 'Development', 'slug' => 'development']);
        $course = Course::factory()->create([
            'category_id' => $category->id,
            'is_published' => true,
            'price' => 0, // Free course
        ]);

        $response = $this->actingAs($user)
            ->post(route('checkout.process', $course));

        $response->assertRedirect(route('courses.show', $course));
        $this->assertTrue($user->hasPurchased($course));
    }
}
