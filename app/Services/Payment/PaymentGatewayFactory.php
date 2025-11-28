<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Illuminate\Support\Facades\App;

class PaymentGatewayFactory
{
    /**
     * Create a payment gateway instance
     * 
     * @param string $gateway
     * @return PaymentGatewayInterface
     * @throws \InvalidArgumentException
     */
    public static function create(string $gateway): PaymentGatewayInterface
    {
        return match($gateway) {
            'paypal' => App::make(PayPalService::class),
            'stripe' => App::make(StripeService::class),
            'razorpay' => App::make(RazorpayService::class),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}")
        };
    }

    /**
     * Get all available payment gateways
     * 
     * @return array
     */
    public static function getAvailableGateways(): array
    {
        return [
            'paypal' => [
                'name' => 'PayPal',
                'logo' => '/images/payment/paypal.png',
                'enabled' => config('services.paypal.enabled', true),
            ],
            'stripe' => [
                'name' => 'Stripe',
                'logo' => '/images/payment/stripe.png',
                'enabled' => config('services.stripe.enabled', true),
            ],
            'razorpay' => [
                'name' => 'Razorpay',
                'logo' => '/images/payment/razorpay.png',
                'enabled' => config('services.razorpay.enabled', true),
            ],
        ];
    }
}
