<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        $title = $this->faker->sentence;
        return [
            'instructor_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->text,
            'requirements' => $this->faker->paragraph,
            'what_you_learn' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'level' => 'beginner',
            'status' => 'published',
            'is_free' => false,
            'is_featured' => false,
        ];
    }
}
