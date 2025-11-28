<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Video Providers
    |------------------------------------------------------------------------|
    | Supported video providers for course lessons
    */
    'video_providers' => [
        'self' => 'Self Hosted',
        'youtube' => 'YouTube',
        'vimeo' => 'Vimeo',
        'external' => 'External URL',
    ],

    /*
    |--------------------------------------------------------------------------
    | Course Levels
    |--------------------------------------------------------------------------
    */
    'course_levels' => [
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
        'all' => 'All Levels',
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Limits
    |--------------------------------------------------------------------------
    */
    'upload' => [
        'max_image_size' => 5120, // 5MB in KB
        'max_video_size' => 512000, // 500MB in KB
        'max_document_size' => 10240, // 10MB in KB
        'allowed_image_types' => ['jpg', 'jpeg', 'png', 'gif', 'webp'],
        'allowed_video_types' => ['mp4', 'webm', 'ogg', 'mov'],
        'allowed_document_types' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Quiz Settings
    |--------------------------------------------------------------------------
    */
    'quiz' => [
        'default_pass_percentage' => 50,
        'default_time_limit' => null, // minutes, null means no limit
        'default_max_attempts' => 0, // 0 means unlimited
        'question_types' => [
            'single' => 'Single Choice',
            'multiple' => 'Multiple Choice',
            'true_false' => 'True/False',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Certificate Settings
    |--------------------------------------------------------------------------
    */
    'certificate' => [
        'require_100_percent' => false, // Require 100% completion or just all lessons watched
        'template_path' => resource_path('views/certificates/template.blade.php'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Settings
    |--------------------------------------------------------------------------
    */
    'payment' => [
        'currencies' => [
            'USD' => ['symbol' => '$', 'name' => 'US Dollar'],
            'EUR' => ['symbol' => '€', 'name' => 'Euro'],
            'GBP' => ['symbol' => '£', 'name' => 'British Pound'],
            'INR' => ['symbol' => '₹', 'name' => 'Indian Rupee'],
        ],
        'default_currency' => 'USD',
        'instructor_commission_percentage' => 70, // 70% to instructor, 30% to platform
        'withdrawal_hold_days' => 14, // Days before earnings become available
        'min_withdrawal_amount' => 50,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */
    'pagination' => [
        'courses_per_page' => 12,
        'students_per_page' => 20,
        'orders_per_page' => 20,
        'reviews_per_page' => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | SEO Settings
    |--------------------------------------------------------------------------
    */
    'seo' => [
        'default_meta_title' => 'LearnHub - Online Learning Platform',
        'default_meta_description' => 'Learn from industry experts with our comprehensive online courses.',
        'default_meta_keywords' => 'online courses, learning, education, training',
    ],

];
