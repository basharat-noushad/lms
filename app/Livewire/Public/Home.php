<?php

namespace App\Livewire\Public;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        $featuredCourses = Course::where('status', 'published')
            ->where('is_featured', true)
            ->with(['instructor', 'category', 'reviews'])
            ->latest()
            ->take(6)
            ->get();

        $popularCategories = Category::withCount('courses')
            ->orderByDesc('courses_count')
            ->take(8)
            ->get();

        $latestCourses = Course::where('status', 'published')
            ->with(['instructor', 'category', 'reviews'])
            ->latest()
            ->take(6)
            ->get();

        return view('livewire.public.home', [
            'featuredCourses' => $featuredCourses,
            'popularCategories' => $popularCategories,
            'latestCourses' => $latestCourses,
        ])->layout('layouts.public');
    }
}
