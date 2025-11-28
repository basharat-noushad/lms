<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;

class StripeService implements PaymentGatewayInterface
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function getName(): string
    {
        return 'stripe';
    }

    public function createPayment(float $amount, string $returnUrl, string $cancelUrl, array $metadata = []): array
    {
        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $metadata['course_title'] ?? 'Course Purchase',
                        ],
                        'unit_amount' => $amount * 100, // Stripe uses cents
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $returnUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => $metadata,
            ]);

            return [
                'id' => $session->id,
                'status' => 'CREATED',
                'links' => [
                    ['rel' => 'approve', 'href' => $session->url]
                ]
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Create Session Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    public function capturePayment(string $paymentId, array $data = []): array
    {
        try {
            $session = Session::retrieve($paymentId);
            
            return [
                'id' => $session->payment_intent,
                'status' => $session->payment_status === 'paid' ? 'COMPLETED' : 'PENDING',
                'session' => $session
            ];
        } catch (\Exception $e) {
            Log::error('Stripe Retrieve Session Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
