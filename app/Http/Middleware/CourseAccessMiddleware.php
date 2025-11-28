<?php

namespace App\Http\Middleware;

use App\Models\Course;
use Closure;
use Illuminate\Http\Request;

class CourseAccessMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $course = $request->route('course') ?? $request->route('id');
        
        if ($course instanceof \App\Models\Course) {
            $courseId = $course->id;
        } else {
            $courseId = $course;
            $course = \App\Models\Course::find($courseId);
        }

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Admins have access to everything
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Instructors have access to their own courses
        if ($course && $course->instructor_id === $user->id) {
            return $next($request);
        }

        // Check if user is enrolled in the course
        $isEnrolled = $user->enrollments()->where('course_id', $courseId)->exists();
        
        if (!$isEnrolled) {
            abort(403, 'You must be enrolled in this course to access it.');
        }

        return $next($request);
    }
}
