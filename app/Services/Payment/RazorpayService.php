<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Razorpay\Api\Api;
use Illuminate\Support\Facades\Log;

class RazorpayService implements PaymentGatewayInterface
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }

    public function getName(): string
    {
        return 'razorpay';
    }

    public function createPayment(float $amount, string $returnUrl, string $cancelUrl, array $metadata = []): array
    {
        try {
            $order = $this->api->order->create([
                'amount' => $amount * 100, // Razorpay uses paise (smallest currency unit)
                'currency' => 'INR',
                'receipt' => 'order_' . time(),
                'notes' => $metadata
            ]);

            return [
                'id' => $order->id,
                'status' => 'CREATED',
                'amount' => $order->amount,
                'currency' => $order->currency,
                'key' => config('services.razorpay.key'),
                'return_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Create Order Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    public function capturePayment(string $paymentId, array $data = []): array
    {
        try {
            // Verify payment signature
            $attributes = [
                'razorpay_order_id' => $data['razorpay_order_id'] ?? '',
                'razorpay_payment_id' => $data['razorpay_payment_id'] ?? '',
                'razorpay_signature' => $data['razorpay_signature'] ?? ''
            ];

            $this->api->utility->verifyPaymentSignature($attributes);

            // Fetch payment details
            $payment = $this->api->payment->fetch($data['razorpay_payment_id']);

            return [
                'id' => $payment->id,
                'status' => $payment->status === 'captured' ? 'COMPLETED' : 'PENDING',
                'payment' => $payment
            ];
        } catch (\Exception $e) {
            Log::error('Razorpay Verify Payment Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
