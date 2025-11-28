<?php

require __DIR__ . '/vendor/autoload.php';

use Srmklive\PayPal\Services\PayPal as PayPalClient;

try {
    echo "Instantiating PayPalClient...\n";
    $provider = new PayPalClient;
    echo "PayPalClient instantiated successfully.\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
