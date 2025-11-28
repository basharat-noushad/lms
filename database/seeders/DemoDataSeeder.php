<?php

namespace Database\Seeders;

use App\Models\{Category, Course, User, Section, Lesson, Page};
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->createCourses();
        $this->createPages();
        
        $this->command->info('Demo data created successfully!');
    }

    private function createCourses(): void
    {
        $instructors = User::where('role', 'instructor')->get();
        $categories = Category::whereNotNull('parent_id')->get(); // Get subcategories

        $courses = [
            [
                'title' => 'Complete Web Development Bootcamp 2024',
                'subtitle' => 'Learn HTML, CSS, JavaScript, React, Node.js and more',
                'description' => '<p>Master web development with this comprehensive bootcamp. From basics to advanced topics, you\'ll learn everything needed to become a professional web developer.</p><p>This course covers HTML5, CSS3, JavaScript ES6+, React, Node.js, Express, MongoDB, and deployment strategies.</p>',
                'requirements' => json_encode(['Basic computer skills', 'Internet connection', 'Willingness to learn']),
                'what_you_learn' => json_encode(['Build responsive websites', 'Create web applications with React', 'Develop backend APIs with Node.js', 'Deploy applications to production']),
                'target_audience' => json_encode(['Beginners wanting to learn web development', 'Career changers', 'Entrepreneurs']),
                'level' => 'beginner',
                'price' => 99.99,
                'is_published' => true,
                'status' => 'approved',
                'is_featured' => true,
            ],
            [
                'title' => 'UI/UX Design Masterclass',
                'subtitle' => 'Design beautiful and functional user interfaces',
                'description' => '<p>Learn the principles of UI/UX design and create stunning user experiences. This course covers design thinking, wireframing, prototyping, and user testing.</p>',
                'requirements' => json_encode(['No prior design experience needed', 'Figma or Adobe XD (free)']),
                'what_you_learn' => json_encode(['Design principles', 'User research techniques', 'Wireframing and prototyping', 'Usability testing']),
                'target_audience' => json_encode(['Aspiring designers', 'Developers wanting design skills', 'Product managers']),
                'level' => 'intermediate',
                'price' => 79.99,
                'sale_price' => 49.99,
                'is_published' => true,
                'status' => 'approved',
                'is_featured' => true,
            ],
            [
                'title' => 'Machine Learning A-Z',
                'subtitle' => 'Learn to build ML models with Python',
                'description' => '<p>Dive into the world of machine learning and artificial intelligence. Learn to build predictive models using Python, scikit-learn, and TensorFlow.</p>',
                'requirements' => json_encode(['Basic Python knowledge', 'High school math', 'Computer with Python installed']),
                'what_you_learn' => json_encode(['Machine learning fundamentals', 'Regression and classification', 'Neural networks', 'Real-world ML projects']),
                'target_audience' => json_encode(['Data scientists', 'Python developers', 'AI enthusiasts']),
                'level' => 'intermediate',
                'price' => 129.99,
                'is_published' => true,
                'status' => 'approved',
            ],
            [
                'title' => 'Digital Marketing Fundamentals',
                'subtitle' => 'Master online marketing strategies',
                'description' => '<p>Learn digital marketing from scratch. This course covers SEO, social media marketing, email marketing, and paid advertising.</p>',
                'requirements' => json_encode(['No prerequisites', 'Basic internet usage']),
                'what_you_learn' => json_encode(['SEO basics', 'Social media strategies', 'Email campaigns', 'Google Ads']),
                'target_audience' => json_encode(['Business owners', 'Marketing professionals', 'Freelancers']),
                'level' => 'beginner',
                'price' => 59.99,
                'is_published' => true,
                'status' => 'approved',
            ],
        ];

        foreach ($courses as $index => $courseData) {
            $instructor = $instructors->get($index % $instructors->count());
            $category = $categories->get($index % $categories->count());

            $course = Course::create(array_merge($courseData, [
                'instructor_id' => $instructor->id,
                'category_id' => $category->id,
                'language' => 'English',
                'published_at' => now(),
            ]));

            // Create sections and lessons
            $this->createCurriculum($course);
        }
    }

    private function createCurriculum(Course $course): void
    {
        $sectionsData = [
            ['title' => 'Introduction', 'lessons' => [
                ['title' => 'Welcome to the Course', 'content_type' => 'video', 'is_free_preview' => true, 'video_duration' => 300],
                ['title' => 'Course Overview', 'content_type' => 'text'],
            ]],
            ['title' => 'Getting Started', 'lessons' => [
                ['title' => 'Setup Your Environment', 'content_type' => 'video', 'video_duration' => 600],
                ['title' => 'First Steps', 'content_type' => 'video', 'video_duration' => 900],
                ['title' => 'Practice Exercise', 'content_type' => 'text'],
            ]],
            ['title' => 'Core Concepts', 'lessons' => [
                ['title' => 'Fundamental Principles', 'content_type' => 'video', 'video_duration' => 1200],
                ['title' => 'Advanced Techniques', 'content_type' => 'video', 'video_duration' => 1500],
                ['title' => 'Hands-on Project', 'content_type' => 'text'],
            ]],
        ];

        foreach ($sectionsData as $index => $sectionData) {
            $section = Section::create([
                'course_id' => $course->id,
                'title' => $sectionData['title'],
                'sort_order' => $index,
            ]);

            foreach ($sectionData['lessons'] as $lessonIndex => $lessonData) {
                Lesson::create(array_merge($lessonData, [
                    'section_id' => $section->id,
                    'description' => 'Learn about ' . strtolower($lessonData['title']),
                    'text_content' => $lessonData['content_type'] === 'text' ? '<p>This is the lesson content...</p>' : null,
                    'video_url' => $lessonData['content_type'] === 'video' ? 'https://www.youtube.com/watch?v=dQw4w9WgXcQ' : null,
                    'video_provider' => $lessonData['content_type'] === 'video' ? 'youtube' : 'self',
                    'video_duration' => $lessonData['video_duration'] ?? 0,
                    'sort_order' => $lessonIndex,
                    'is_published' => true,
                ]));
            }
        }

        // Update course stats
        $course->update([
            'total_lessons' => $course->lessons()->count(),
            'total_duration' => $course->lessons()->sum('video_duration'),
        ]);
    }

    private function createPages(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => '<h1>About LearnHub</h1><p>We are dedicated to making quality education accessible to everyone.</p>',
                'meta_title' => 'About LearnHub - Our Mission',
                'is_published' => true,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy',
                'content' => '<h1>Privacy Policy</h1><p>Your privacy is important to us...</p>',
                'is_published' => true,
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms',
                'content' => '<h1>Terms of Service</h1><p>By using our platform, you agree to...</p>',
                'is_published' => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }
    }
}
