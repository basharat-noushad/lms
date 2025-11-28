<?php

namespace App\Helpers;

use App\Models\Course;

class SeoHelper
{
    public static function generateMetaTags($title = null, $description = null, $image = null, $type = 'website')
    {
        $appName = config('app.name', 'LearnHub');
        $title = $title ? "$title - $appName" : $appName;
        $description = $description ?? "LearnHub is the best platform to learn new skills online.";
        $image = $image ?? asset('images/og-image.jpg');
        $url = url()->current();

        return "
            <title>$title</title>
            <meta name=\"description\" content=\"$description\">
            
            <!-- Open Graph / Facebook -->
            <meta property=\"og:type\" content=\"$type\">
            <meta property=\"og:url\" content=\"$url\">
            <meta property=\"og:title\" content=\"$title\">
            <meta property=\"og:description\" content=\"$description\">
            <meta property=\"og:image\" content=\"$image\">

            <!-- Twitter -->
            <meta property=\"twitter:card\" content=\"summary_large_image\">
            <meta property=\"twitter:url\" content=\"$url\">
            <meta property=\"twitter:title\" content=\"$title\">
            <meta property=\"twitter:description\" content=\"$description\">
            <meta property=\"twitter:image\" content=\"$image\">
        ";
    }

    public static function generateCourseSchema(Course $course)
    {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "Course",
            "name" => $course->title,
            "description" => $course->description,
            "provider" => [
                "@type" => "Organization",
                "name" => config('app.name'),
                "sameAs" => url('/')
            ],
            "offers" => [
                "@type" => "Offer",
                "category" => "Paid",
                "priceCurrency" => "USD",
                "price" => $course->price
            ],
            "hasCourseInstance" => [
                "@type" => "CourseInstance",
                "courseMode" => "online",
                "instructor" => [
                    "@type" => "Person",
                    "name" => $course->instructor->name
                ]
            ]
        ];

        return '<script type="application/ld+json">' . json_encode($schema) . '</script>';
    }
}
