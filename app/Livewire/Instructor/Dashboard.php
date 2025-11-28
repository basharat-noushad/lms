<?php

namespace App\Livewire\Instructor;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $instructorId = Auth::id();

        // Stats
        $totalCourses = Course::where('instructor_id', $instructorId)->count();
        $activeCourses = Course::where('instructor_id', $instructorId)->where('status', 'published')->count();
        
        // Get course IDs for this instructor to filter enrollments and reviews
        $courseIds = Course::where('instructor_id', $instructorId)->pluck('id');
        
        $totalEnrollments = Enrollment::whereIn('course_id', $courseIds)->count();
        
        // Calculate average rating
        $averageRating = Review::whereIn('course_id', $courseIds)->avg('rating') ?? 0;

        // Recent Enrollments
        $recentEnrollments = Enrollment::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(5)
            ->get();

        // Recent Reviews
        $recentReviews = Review::with(['user', 'course'])
            ->whereIn('course_id', $courseIds)
            ->latest()
            ->take(5)
            ->get();

        // Calculate total earnings (mock calculation for now as we don't have full order splitting yet)
        // In a real app, we'd query the Earnings table
        $totalEarnings = 0; // Placeholder until Earnings model is fully populated

        return view('livewire.instructor.dashboard', [
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'totalEnrollments' => $totalEnrollments,
            'averageRating' => $averageRating,
            'totalEarnings' => $totalEarnings,
            'recentEnrollments' => $recentEnrollments,
            'recentReviews' => $recentReviews,
        ])->layout('layouts.instructor');
    }
}
