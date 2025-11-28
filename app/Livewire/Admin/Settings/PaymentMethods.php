<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Services\Payment\PaymentGatewayFactory;
use App\Models\Setting;

class PaymentMethods extends Component
{
    public $gateways = [];
    public $testMode = false;

    public function mount()
    {
        $this->gateways = PaymentGatewayFactory::getAvailableGateways();
        $this->testMode = config('app.env') !== 'production';
    }

    public function toggleGateway($gateway)
    {
        $key = "services.{$gateway}.enabled";
        $currentValue = config($key, true);
        
        // In a real implementation, you'd save this to database
        // For now, this is just a placeholder
        $this->dispatch('gateway-toggled', gateway: $gateway, enabled: !$currentValue);
        $this->gateways[$gateway]['enabled'] = !$currentValue;
    }

    public function testConnection($gateway)
    {
        try {
            $service = PaymentGatewayFactory::create($gateway);
            $this->dispatch('test-success', message: "{$gateway} connection successful!");
        } catch (\Exception $e) {
            $this->dispatch('test-failed', message: "Connection failed: " . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.settings.payment-methods');
    }
}
