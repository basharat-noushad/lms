@extends('emails.layout')

@section('content')
    <h2>Order Confirmed! 🎉</h2>
    
    <p>Hi {{ $order->user->name }},</p>
    
    <p>Thank you for your purchase! Your order has been confirmed and you now have access to your course(s).</p>

    <div class="info-box">
        <p style="margin: 0;"><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p style="margin: 8px 0 0 0;"><strong>Order Date:</strong> {{ $order->created_at->format('F j, Y') }}</p>
        <p style="margin: 8px 0 0 0;"><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
    </div>

    <h3 style="color: #2d3748; margin-top: 30px; margin-bottom: 16px;">Order Summary</h3>
    
    @foreach($order->items as $item)
        <div class="course-item">
            @if($item->course->thumbnail)
                <img src="{{ asset('storage/' . $item->course->thumbnail) }}" alt="{{ $item->course->title }}">
            @else
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; margin-right: 16px;"></div>
            @endif
            <div class="course-info">
                <h3>{{ $item->course->title }}</h3>
                <p>by {{ $item->course->instructor->name }}</p>
                <p style="font-weight: 600; color: #2d3748; margin-top: 8px;">${{ number_format($item->price, 2) }}</p>
            </div>
        </div>
    @endforeach

    <div class="info-box" style="margin-top: 30px; background-color: #f0f4ff; border-left-color: #667eea;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 18px; font-weight: 600; color: #2d3748;">Total</span>
            <span style="font-size: 20px; font-weight: 700; color: #667eea;">${{ number_format($order->total_amount, 2) }}</span>
        </div>
    </div>

    <div>
        <a href="{{ route('home') }}" class="button">Start Learning</a>
    </div>

    <p style="color: #718096; font-size: 14px; margin-top: 30px;">
        Need help? Contact our support team at <a href="mailto:support@learnhub.com" style="color: #667eea;">support@learnhub.com</a>
    </p>
@endsection
