<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'LearnHub LMS' }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f5f7;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            color: #ffffff;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
        }
        .button {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
        h2 {
            color: #2d3748;
            font-size: 20px;
            margin-top: 0;
        }
        p {
            color: #4a5568;
            line-height: 1.6;
            margin: 16px 0;
        }
        .info-box {
            background-color: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 16px;
            margin: 20px 0;
        }
        .course-item {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin: 12px 0;
            display: flex;
            align-items: center;
        }
        .course-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 16px;
        }
        .course-info h3 {
            margin: 0 0 8px 0;
            color: #2d3748;
            font-size: 16px;
        }
        .course-info p {
            margin: 0;
            font-size: 14px;
            color: #718096;
        }
        @media only screen and (max-width: 600px) {
            .content {
                padding: 20px 15px;
            }
            .header h1 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>LearnHub LMS</h1>
        </div>

        <!-- Content -->
        <div class="content">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin-bottom: 10px;">
                <strong>LearnHub LMS</strong><br>
                Your gateway to knowledge and success
            </p>
            <p style="margin: 10px 0;">
                <a href="{{ config('app.url') }}">Visit Website</a> |
                <a href="{{ config('app.url') }}/support">Support</a> |
                <a href="{{ config('app.url') }}/privacy">Privacy Policy</a>
            </p>
            <p style="font-size: 12px; color: #9ca3af; margin-top: 20px;">
                © {{ date('Y') }} LearnHub LMS. All rights reserved.<br>
                You're receiving this email because you have an account with us.
            </p>
        </div>
    </div>
</body>
</html>
