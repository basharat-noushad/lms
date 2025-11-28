<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate of Completion</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .certificate {
            width: 210mm;
            height: 297mm;
            padding: 40mm;
            box-sizing: border-box;
            position: relative;
            background: white;
            margin: 0 auto;
        }
        .border {
            border: 15px solid #667eea;
            padding: 30px;
            height: 100%;
            position: relative;
        }
        .inner-border {
            border: 2px solid #764ba2;
            padding: 40px;
            height: 100%;
            text-align: center;
        }
        .logo {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 48px;
            color: #2d3748;
            margin: 30px 0;
            font-weight: normal;
            letter-spacing: 2px;
        }
        .subtitle {
            font-size: 20px;
            color: #4a5568;
            margin: 20px 0;
        }
        .recipient {
            font-size: 42px;
            color: #667eea;
            font-weight: bold;
            margin: 40px 0;
            font-style: italic;
        }
        .course-title {
            font-size: 28px;
            color: #2d3748;
            margin: 30px 0;
            font-weight: bold;
        }
        .instructor {
            font-size: 18px;
            color: #4a5568;
            margin: 20px 0;
        }
        .date {
            font-size: 16px;
            color: #718096;
            margin: 40px 0 20px 0;
        }
        .certificate-number {
            font-size: 14px;
            color: #a0aec0;
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
        }
        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-around;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            width: 200px;
            border-top: 2px solid #2d3748;
            margin: 0 auto 10px;
        }
        .seal {
            position: absolute;
            bottom: 80px;
            right: 80px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 5px solid #667eea;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            color: #667eea;
            font-weight: bold;
            text-align: center;
            transform: rotate(-15deg);
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="border">
            <div class="inner-border">
                <div class="logo">LearnHub LMS</div>
                
                <h1>Certificate of Completion</h1>
                
                <div class="subtitle">This is to certify that</div>
                
                <div class="recipient">{{ $user->name }}</div>
                
                <div class="subtitle">has successfully completed the course</div>
                
                <div class="course-title">{{ $course->title }}</div>
                
                <div class="instructor">Instructed by {{ $course->instructor->name }}</div>
                
                <div class="date">
                    Date of Completion: {{ $certificate->issued_at->format('F d, Y') }}
                </div>
                
                <div class="signature-section">
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>Platform Administrator</div>
                    </div>
                    <div class="signature">
                        <div class="signature-line"></div>
                        <div>{{ $course->instructor->name }}</div>
                        <div style="font-size: 12px; color: #718096;">Course Instructor</div>
                    </div>
                </div>
                
                <div class="certificate-number">
                    Certificate Number: {{ $certificate->certificate_number }}
                </div>
                
                <div class="seal">
                    VERIFIED<br>CERTIFICATE
                </div>
            </div>
        </div>
    </div>
</body>
</html>
