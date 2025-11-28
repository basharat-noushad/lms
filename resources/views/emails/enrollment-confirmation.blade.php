@extends('emails.layout')

@section('content')
    <h2>Welcome to {{ $course->title }}! 📚</h2>
    
    <p>Hi {{ $user->name }},</p>
    
    <p>Congratulations! You've been successfully enrolled in <strong>{{ $course->title }}</strong>. We're excited to have you join this learning journey.</p>

    @if($course->thumbnail)
        <div style="margin: 30px 0; text-align: center;">
            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" style="max-width: 100%; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        </div>
    @endif

    <div class="info-box">
        <h3 style="margin-top: 0; color: #2d3748; font-size: 16px;">Course Details</h3>
        <p style="margin: 8px 0;"><strong>Instructor:</strong> {{ $course->instructor->name }}</p>
        <p style="margin: 8px 0;"><strong>Level:</strong> {{ ucfirst($course->level) }}</p>
        @if($course->total_lessons)
            <p style="margin: 8px 0;"><strong>Lessons:</strong> {{ $course->total_lessons }}</p>
        @endif
    </div>

    <div>
        <a href="{{ route('courses.show', $course->slug) }}" class="button">Start Learning Now</a>
    </div>

    <h3 style="color: #2d3748; margin-top: 30px;">What's Next?</h3>
    <ul style="color: #4a5568; line-height: 1.8;">
        <li>Access your course dashboard and start with the first lesson</li>
        <li>Download any course materials and resources</li>
        <li>Engage with the community in the discussion section</li>
        <li>Track your progress as you complete each lesson</li>
    </ul>

    <p>If you have any questions about the course, feel free to reach out to your instructor or our support team.</p>

    <p style="color: #718096; font-size: 14px; margin-top: 30px;">
        Happy learning! 🎓
    </p>
@endsection
