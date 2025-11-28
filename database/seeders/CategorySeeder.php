<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Learn to build modern websites and web applications',
                'icon' => 'code',
                'is_active' => true,
                'sort_order' => 1,
                'subcategories' => [
                    ['name' => 'Frontend Development', 'slug' => 'frontend-development', 'icon' => 'layout'],
                    ['name' => 'Backend Development', 'slug' => 'backend-development', 'icon' => 'server'],
                    ['name' => 'Full Stack Development', 'slug' => 'full-stack-development', 'icon' => 'layers'],
                ],
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'Master the art of digital design',
                'icon' => 'palette',
                'is_active' => true,
                'sort_order' => 2,
                'subcategories' => [
                    ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design', 'icon' => 'smartphone'],
                    ['name' => 'Graphic Design', 'slug' => 'graphic-design', 'icon' => 'image'],
                    ['name' => 'Web Design', 'slug' => 'web-design', 'icon' => 'monitor'],
                ],
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Analyze data and build intelligent systems',
                'icon' => 'trending-up',
                'is_active' => true,
                'sort_order' => 3,
                'subcategories' => [
                    ['name' => 'Machine Learning', 'slug' => 'machine-learning', 'icon' => 'cpu'],
                    ['name' => 'Data Analysis', 'slug' => 'data-analysis', 'icon' => 'bar-chart-2'],
                    ['name' => 'Python for Data Science', 'slug' => 'python-data-science', 'icon' => 'code'],
                ],
            ],
            [
                'name' => 'Business',
                'slug' => 'business',
                'description' => 'Develop essential business skills',
                'icon' => 'briefcase',
                'is_active' => true,
                'sort_order' => 4,
                'subcategories' => [
                    ['name' => 'Marketing', 'slug' => 'marketing', 'icon' => 'megaphone'],
                    ['name' => 'Entrepreneurship', 'slug' => 'entrepreneurship', 'icon' => 'zap'],
                    ['name' => 'Project Management', 'slug' => 'project-management', 'icon' => 'clipboard'],
                ],
            ],
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Capture stunning images',
                'icon' => 'camera',
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'name' => 'Music',
                'slug' => 'music',
                'description' => 'Learn instruments and music production',
                'icon' => 'music',
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($categories as $categoryData) {
            $subcategories = $categoryData['subcategories'] ?? [];
            unset($categoryData['subcategories']);

            $category = Category::create($categoryData);

            foreach ($subcategories as $subData) {
                $subData['parent_id'] = $category->id;
                $subData['is_active'] = true;
                $subData['description'] = $subData['description'] ?? '';
                Category::create($subData);
            }
        }

        $this->command->info('Created categories with subcategories');
    }
}
