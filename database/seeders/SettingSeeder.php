<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'LearnHub', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Learn Anything, Anywhere', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_logo', 'value' => null, 'type' => 'file', 'group' => 'general'],
            ['key' => 'site_favicon', 'value' => null, 'type' => 'file', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'support@learnhub.com', 'type' => 'text', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+1 (555) 123-4567', 'type' => 'text', 'group' => 'general'],
            
            // Payment
            ['key' => 'currency', 'value' => 'USD', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'currency_symbol', 'value' => '$', 'type' => 'text', 'group' => 'payment'],
            ['key' => 'instructor_commission', 'value' => '70', 'type' => 'number', 'group' => 'payment'],
            ['key' => 'min_withdrawal', 'value' => '50', 'type' => 'number', 'group' => 'payment'],
            ['key' => 'withdrawal_hold_days', 'value' => '14', 'type' => 'number', 'group' => 'payment'],
            ['key' => 'stripe_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'payment'],
            ['key' => 'paypal_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'payment'],
            
            // Features
            ['key' => 'registration_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'instructor_registration', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'course_approval_required', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'reviews_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            ['key' => 'certificates_enabled', 'value' => 'true', 'type' => 'boolean', 'group' => 'features'],
            
            // SEO
            ['key' => 'meta_title', 'value' => 'LearnHub - Online Learning Platform', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Learn from industry experts with our comprehensive online courses. Master new skills at your own pace.', 'type' => 'text', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'online courses, learning, education, training, skills', 'type' => 'text', 'group' => 'seo'],
            
            // Social
            ['key' => 'facebook_url', 'value' => 'https://facebook.com/learnhub', 'type' => 'text', 'group' => 'social'],
            ['key' => 'twitter_url', 'value' => 'https://twitter.com/learnhub', 'type' => 'text', 'group' => 'social'],
            ['key' => 'instagram_url', 'value' => 'https://instagram.com/learnhub', 'type' => 'text', 'group' => 'social'],
            ['key' => 'youtube_url', 'value' => 'https://youtube.com/@learnhub', 'type' => 'text', 'group' => 'social'],
            ['key' => 'linkedin_url', 'value' => 'https://linkedin.com/company/learnhub', 'type' => 'text', 'group' => 'social'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        $this->command->info('Created ' . count($settings) . ' settings');
    }
}
