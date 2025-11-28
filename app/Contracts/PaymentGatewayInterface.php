<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    /**
     * Create a payment order/session
     * 
     * @param float $amount
     * @param string $returnUrl
     * @param string $cancelUrl
     * @param array $metadata
     * @return array
     */
    public function createPayment(float $amount, string $returnUrl, string $cancelUrl, array $metadata = []): array;

    /**
     * Capture/verify a payment
     * 
     * @param string $paymentId
     * @param array $data
     * @return array
     */
    public function capturePayment(string $paymentId, array $data = []): array;

    /**
     * Get the gateway name
     * 
     * @return string
     */
    public function getName(): string;
}
