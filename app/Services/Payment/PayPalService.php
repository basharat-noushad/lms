<?php

namespace App\Services\Payment;

use App\Contracts\PaymentGatewayInterface;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Log;

class PayPalService implements PaymentGatewayInterface
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    public function getName(): string
    {
        return 'paypal';
    }

    public function createPayment(float $amount, string $returnUrl, string $cancelUrl, array $metadata = []): array
    {
        try {
            $this->provider->getAccessToken();
            $response = $this->provider->createOrder([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $amount
                        ]
                    ]
                ],
                "application_context" => [
                    "return_url" => $returnUrl,
                    "cancel_url" => $cancelUrl
                ]
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('PayPal Create Order Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }

    public function capturePayment(string $paymentId, array $data = []): array
    {
        try {
            $this->provider->getAccessToken();
            $response = $this->provider->capturePaymentOrder($paymentId);
            return $response;
        } catch (\Exception $e) {
            Log::error('PayPal Capture Payment Failed: ' . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}
