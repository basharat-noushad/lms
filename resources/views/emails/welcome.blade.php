@extends('emails.layout')

@section('content')
    <h2>Welcome to LearnHub LMS! 🎓</h2>
    
    <p>Hi {{ $user->name }},</p>
    
    <p>We're thrilled to have you join our learning community! Your account has been successfully created, and you're now ready to explore thousands of courses taught by expert instructors.</p>

    <div>
        <a href="{{ route('home') }}" class="button">Explore Courses</a>
    </div>

    <h3 style="color: #2d3748; margin-top: 30px;">Getting Started</h3>
    
    <div style="margin: 20px 0;">
        <div style="padding: 16px; background-color: #f7fafc; border-radius: 8px; margin-bottom: 12px;">
            <h4 style="margin: 0 0 8px 0; color: #667eea; font-size: 16px;">1. Browse Our Catalog</h4>
            <p style="margin: 0; color: #4a5568; font-size: 14px;">Discover courses in programming, design, business, and more.</p>
        </div>

        <div style="padding: 16px; background-color: #f7fafc; border-radius: 8px; margin-bottom: 12px;">
            <h4 style="margin: 0 0 8px 0; color: #667eea; font-size: 16px;">2. Enroll in a Course</h4>
            <p style="margin: 0; color: #4a5568; font-size: 14px;">Choose from free and paid courses that match your interests.</p>
        </div>

       <div style="padding: 16px; background-color: #f7fafc; border-radius: 8px; margin-bottom: 12px;">
            <h4 style="margin: 0 0 8px 0; color: #667eea; font-size: 16px;">3. Start Learning</h4>
            <p style="margin: 0; color: #4a5568; font-size: 14px;">Access your courses anytime, anywhere, and learn at your own pace.</p>
        </div>
    </div>

    <div class="info-box" style="background-color: #f0f9ff; border-left-color: #0ea5e9;">
        <h4 style="margin: 0 0 8px 0; color: #0369a1;">💡 Pro Tip</h4>
        <p style="margin: 0; color: #075985; font-size: 14px;">
            Complete your profile and tell us about your learning goals. This helps us recommend courses that are perfect for you!
        </p>
    </div>

    <h3 style="color: #2d3748; margin-top: 30px;">Why LearnHub?</h3>
    <ul style="color: #4a5568; line-height: 1.8;">
        <li><strong>Expert Instructors</strong> - Learn from industry professionals</li>
        <li><strong>Lifetime Access</strong> - Access your courses anytime, forever</li>
        <li><strong>Certificates</strong> - Earn certificates upon course completion</li>
        <li><strong>Community</strong> - Connect with fellow learners</li>
    </ul>

    <p>If you have any questions, our support team is here to help. Just reply to this email or visit our help center.</p>

    <p style="color: #718096; font-size: 14px; margin-top: 30px;">
        Welcome aboard, and happy learning! 🚀
    </p>
@endsection
