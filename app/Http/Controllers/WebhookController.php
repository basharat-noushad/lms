<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Mail\EnrollmentConfirmation;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Razorpay\Api\Api;

class WebhookController extends Controller
{
    /**
     * Handle Stripe webhook
     */
    public function stripe(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
        } catch (\UnexpectedValueException $e) {
            Log::error('Stripe Webhook: Invalid payload');
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            Log::error('Stripe Webhook: Invalid signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $this->handleStripeCheckoutCompleted($session);
                break;

            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                Log::info('Stripe payment succeeded', ['payment_intent' => $paymentIntent->id]);
                break;

            default:
                Log::info('Stripe webhook: Unhandled event type', ['type' => $event->type]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handle Razorpay webhook
     */
    public function razorpay(Request $request)
    {
        $webhookSecret = config('services.razorpay.webhook_secret');
        $webhookSignature = $request->header('X-Razorpay-Signature');
        $webhookBody = $request->getContent();

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
            $api->utility->verifyWebhookSignature($webhookBody, $webhookSignature, $webhookSecret);
        } catch (\Exception $e) {
            Log::error('Razorpay Webhook: Invalid signature', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $data = $request->all();

        // Handle the event
        switch ($data['event']) {
            case 'payment.captured':
                $payment = $data['payload']['payment']['entity'];
                $this->handleRazorpayPaymentCaptured($payment);
                break;

            case 'payment.failed':
                $payment = $data['payload']['payment']['entity'];
                Log::warning('Razorpay payment failed', ['payment_id' => $payment['id']]);
                break;

            default:
                Log::info('Razorpay webhook: Unhandled event type', ['type' => $data['event']]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Handle Stripe checkout completed
     */
    protected function handleStripeCheckoutCompleted($session)
    {
        $orderId = $session->metadata->order_id ?? null;

        if (!$orderId) {
            Log::error('Stripe webhook: No order ID in metadata');
            return;
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('Stripe webhook: Order not found', ['order_id' => $orderId]);
            return;
        }

        if ($order->status === 'paid') {
            Log::info('Stripe webhook: Order already paid', ['order_id' => $orderId]);
            return;
        }

        // Update order and enroll user
        $order->update([
            'status' => 'paid',
            'transaction_id' => $session->payment_intent,
            'payment_details' => json_encode($session),
        ]);

        // Enroll user in courses
        foreach ($order->items as $item) {
            $order->user->enroll($item->course);
            
            // Send enrollment confirmation email
            Mail::to($order->user->email)->queue(
                new EnrollmentConfirmation($item->course, $order->user)
            );
        }
        
        // Send order confirmation email
        Mail::to($order->user->email)->queue(new OrderConfirmation($order));

        Log::info('Stripe webhook: Order processed successfully', ['order_id' => $orderId]);
    }

    /**
     * Handle Razorpay payment captured
     */
    protected function handleRazorpayPaymentCaptured($payment)
    {
        $orderId = $payment['notes']['order_id'] ?? null;

        if (!$orderId) {
            Log::error('Razorpay webhook: No order ID in notes');
            return;
        }

        $order = Order::find($orderId);

        if (!$order) {
            Log::error('Razorpay webhook: Order not found', ['order_id' => $orderId]);
            return;
        }

        if ($order->status === 'paid') {
            Log::info('Razorpay webhook: Order already paid', ['order_id' => $orderId]);
            return;
        }

        // Update order and enroll user
        $order->update([
            'status' => 'paid',
            'transaction_id' => $payment['id'],
            'payment_details' => json_encode($payment),
        ]);

        // Enroll user in courses
        foreach ($order->items as $item) {
            $order->user->enroll($item->course);
            
            // Send enrollment confirmation email
            Mail::to($order->user->email)->queue(
                new EnrollmentConfirmation($item->course, $order->user)
            );
        }
        
        // Send order confirmation email
        Mail::to($order->user->email)->queue(new OrderConfirmation($order));

        Log::info('Razorpay webhook: Order processed successfully', ['order_id' => $orderId]);
    }
}
