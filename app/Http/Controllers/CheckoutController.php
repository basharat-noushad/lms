<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use App\Services\Payment\PayPalService;
use App\Services\Payment\PaymentGatewayFactory;
use App\Mail\OrderConfirmation;
use App\Mail\EnrollmentConfirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function checkout(Course $course, Request $request)
    {
        if (Auth::user()->hasPurchased($course)) {
            return redirect()->route('courses.show', $course)->with('info', 'You already own this course.');
        }

        if ($course->is_free) {
            // Handle free enrollment directly
            Auth::user()->enroll($course);
            return redirect()->route('courses.show', $course)->with('success', 'Enrolled successfully!');
        }

        $paymentMethod = $request->input('payment_method', 'paypal');

        // Create pending order
        $order = Order::create([
            'user_id' => Auth::id(),
            'subtotal' => $course->price,
            'total_amount' => $course->price,
            'status' => 'pending',
            'payment_method' => $paymentMethod,
        ]);

        // Create order item
        $instructorShare = $course->price * 0.70; // 70% to instructor
        $platformShare = $course->price * 0.30;   // 30% to platform

        $order->items()->create([
            'course_id' => $course->id,
            'instructor_id' => $course->instructor_id,
            'price' => $course->price,
            'instructor_share' => $instructorShare,
            'platform_share' => $platformShare,
            'total' => $course->price,
        ]);

        $returnUrl = route('checkout.callback', ['order' => $order->id]);
        $cancelUrl = route('checkout.cancel', ['order' => $order->id]);

        try {
            $gateway = PaymentGatewayFactory::create($paymentMethod);
            $metadata = [
                'order_id' => $order->id,
                'course_title' => $course->title,
            ];
            
            $response = $gateway->createPayment($course->price, $returnUrl, $cancelUrl, $metadata);

            if (isset($response['error'])) {
                return redirect()->route('courses.show', $course)->with('error', 'Payment gateway error: ' . $response['error']);
            }

            if ($paymentMethod === 'razorpay') {
                // For Razorpay, we need to show checkout form
                return view('checkout.razorpay', compact('response', 'order', 'course'));
            }

            // For PayPal and Stripe, redirect to approval URL
            if (isset($response['links'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve') {
                        return redirect()->away($link['href']);
                    }
                }
            }

            return redirect()->route('courses.show', $course)->with('error', 'Unable to initiate payment.');
        } catch (\Exception $e) {
            Log::error('Checkout failed: ' . $e->getMessage());
            return redirect()->route('courses.show', $course)->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function callback(Request $request, Order $order)
    {
        $paymentMethod = $order->payment_method;

        try {
            $gateway = PaymentGatewayFactory::create($paymentMethod);
            
            $paymentData = match($paymentMethod) {
                'paypal' => ['token' => $request->token],
                'stripe' => ['session_id' => $request->session_id ?? $request->token],
                'razorpay' => $request->only(['razorpay_payment_id', 'razorpay_order_id', 'razorpay_signature']),
                default => []
            };

            $paymentId = match($paymentMethod) {
                'paypal' => $request->token,
                'stripe' => $request->session_id ?? $request->token,
                'razorpay' => $request->razorpay_order_id,
                default => ''
            };

            $response = $gateway->capturePayment($paymentId, $paymentData);

            if (isset($response['error'])) {
                return redirect()->route('checkout.cancel')->with('error', 'Payment verification failed.');
            }

            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::transaction(function () use ($order, $response) {
                $order->update([
                    'status' => 'paid',
                    'transaction_id' => $response['id'],
                    'payment_details' => json_encode($response),
                ]);

                // Enroll user in all courses in the order
                foreach ($order->items as $item) {
                    $order->user->enroll($item->course);
                    
                    // Send enrollment confirmation email
                    Mail::to($order->user->email)->queue(
                        new EnrollmentConfirmation($item->course, $order->user)
                    );
                }
                
                // Send order confirmation email
                Mail::to($order->user->email)->queue(new OrderConfirmation($order));

                // Send notification
                app(\App\Services\NotificationService::class)->send(
                    $order->user,
                    'Order Confirmed',
                    "Your order #{$order->id} has been successfully processed.",
                    'order',
                    ['order_id' => $order->id]
                );
            });

            return redirect()->route('checkout.success');
        }

        return redirect()->route('checkout.cancel')->with('error', 'Payment failed.');
        } catch (\Exception $e) {
            Log::error('Payment callback failed: ' . $e->getMessage());
            return redirect()->route('checkout.cancel')->with('error', 'Payment verification failed.');
        }
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
