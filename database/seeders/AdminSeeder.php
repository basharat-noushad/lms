<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@learnhub.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
            'is_active' => true,
            'bio' => 'Platform Administrator',
            'timezone' => 'UTC',
            'language' => 'en',
        ]);

        // Create Sample Instructors
        $instructors = [
            [
                'name' => 'John Smith',
                'email' => 'john@learnhub.com',
                'bio' => 'Senior Web Developer with 10+ years of experience. Passionate about teaching modern web technologies.',
                'headline' => 'Full Stack Developer & Tech Educator',
                'website' => 'https://johnsmith.dev',
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@learnhub.com',
                'bio' => 'UI/UX Designer specializing in creating beautiful and functional user interfaces.',
                'headline' => 'Senior UI/UX Designer',
                'website' => 'https://sarahjohnson.design',
            ],
            [
                'name' => 'Michael Chen',
                'email' => 'michael@learnhub.com',
                'bio' => 'Data Science expert with a passion for machine learning and AI.',
                'headline' => 'Data Scientist & ML Engineer',
                'linkedin' => 'https://linkedin.com/in/michaelchen',
            ],
        ];

        foreach ($instructors as $instructor) {
            User::create(array_merge($instructor, [
                'password' => Hash::make('password'),
                'role' => 'instructor',
                'email_verified_at' => now(),
                'is_active' => true,
                'timezone' => 'UTC',
                'language' => 'en',
            ]));
        }

        // Create Sample Students
        $students = [
            ['name' => 'Alice Brown', 'email' => 'alice@example.com'],
            ['name' => 'Bob Wilson', 'email' => 'bob@example.com'],
            ['name' => 'Carol Davis', 'email' => 'carol@example.com'],
            ['name' => 'David Miller', 'email' => 'david@example.com'],
            ['name' => 'Emma Taylor', 'email' => 'emma@example.com'],
        ];

        foreach ($students as $student) {
            User::create(array_merge($student, [
                'password' => Hash::make('password'),
                'role' => 'student',
                'email_verified_at' => now(),
                'is_active' => true,
            ]));
        }

        $this->command->info('Created 1 admin, 3 instructors, and 5 students');
    }
}
