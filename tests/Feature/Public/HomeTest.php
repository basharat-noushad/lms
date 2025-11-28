<?php

namespace Tests\Feature\Public;

use App\Livewire\Public\Home;
use App\Models\Category;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_correctly()
    {
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Master new skills');
    }

    public function test_home_page_displays_featured_courses()
    {
        $instructor = User::factory()->create(['role' => 'instructor']);
        $category = Category::factory()->create();
        
        $course = Course::factory()->create([
            'instructor_id' => $instructor->id,
            'category_id' => $category->id,
            'status' => 'published',
            'is_featured' => true,
            'title' => 'Featured Course 101'
        ]);

        $this->get(route('home'))
            ->assertSee('Featured Course 101');
    }

    public function test_home_page_displays_popular_categories()
    {
        $category = Category::factory()->create(['name' => 'Popular Category']);
        
        $this->get(route('home'))
            ->assertSee('Popular Category');
    }
}
