<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Payment Gateway Settings</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Manage your payment gateway integrations</p>
    </div>

    @if($testMode)
        <div class="mb-6 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-medium text-yellow-800 dark:text-yellow-300">Test Mode Active - Configure your payment gateways in .env file</span>
            </div>
        </div>
    @endif

    <div class="space-y-6">
        @foreach($gateways as $key => $gateway)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="mr-4">
                            @if($gateway['logo'])
                                <img src="{{ $gateway['logo'] }}" alt="{{ $gateway['name'] }}" class="h-8">
                            @else
                                <div class="h-8 w-20 bg-gray-200 dark:bg-gray-700 rounded flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper($key) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $gateway['name'] }}</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                @if($key === 'paypal')
                                    Global payment gateway supporting 100+ currencies
                                @elseif($key === 'stripe')
                                    Most popular payment processor worldwide
                                @elseif($key === 'razorpay')
                                    Leading payment gateway for India & Asia
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button wire:click="testConnection('{{ $key }}')" 
                                class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            Test Connection
                        </button>
                        <button wire:click="toggleGateway('{{ $key }}')"
                                class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 {{ $gateway['enabled'] ? 'bg-primary-600' : 'bg-gray-200 dark:bg-gray-700' }}"
                                role="switch"
                                aria-checked="{{ $gateway['enabled'] ? 'true' : 'false' }}">
                            <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $gateway['enabled'] ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                </div>

                @if($gateway['enabled'])
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Configuration</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($key === 'paypal')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Client ID</label>
                                    <input type="text" value="{{ config('paypal.client_id') ? '********' . substr(config('paypal.client_id'), -4) : 'Not configured' }}" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Mode</label>
                                    <span class="inline-flex items-center px-3 py-2 text-sm font-medium {{ config('paypal.mode') === 'live' ? 'text-green-700 bg-green-100 dark:bg-green-900/20' : 'text-yellow-700 bg-yellow-100 dark:bg-yellow-900/20' }} rounded-md">
                                        {{ ucfirst(config('paypal.mode', 'sandbox')) }}
                                    </span>
                                </div>
                            @elseif($key === 'stripe')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Publishable Key</label>
                                    <input type="text" value="{{ config('services.stripe.key') ? '********' . substr(config('services.stripe.key'), -4) : 'Not configured' }}" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Webhook URL</label>
                                    <input type="text" value="{{ route('webhooks.stripe') }}" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-500 text-sm">
                                </div>
                            @elseif($key === 'razorpay')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Key ID</label>
                                    <input type="text" value="{{config('services.razorpay.key') ? '********' . substr(config('services.razorpay.key'), -4) : 'Not configured' }}" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Webhook URL</label>
                                    <input type="text" value="{{ route('webhooks.razorpay') }}" readonly class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-gray-50 dark:bg-gray-900 text-gray-500 text-sm">
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">
                            To update credentials, edit the .env file in your application root directory
                        </p>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Help Section -->
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Setup Guide</h3>
        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
            <p><strong>1. PayPal:</strong> Get credentials from <a href="https://developer.paypal.com" target="_blank" class="underline">PayPal Developer</a></p>
            <p><strong>2. Stripe:</strong> Get your API keys from <a href="https://dashboard.stripe.com/apikeys" target="_blank" class="underline">Stripe Dashboard</a></p>
            <p><strong>3. Razorpay:</strong> Generate keys in <a href="https://dashboard.razorpay.com/app/keys" target="_blank" class="underline">Razorpay Dashboard</a></p>
            <p class="mt-3"><strong>Webhooks:</strong> Configure webhook URLs in each gateway's dashboard to receive real-time payment notifications.</p>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('gateway-toggled', (event) => {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message: `${event.gateway} ${event.enabled ? 'enabled' : 'disabled'}`, type: 'success' }
        }));
    });

    $wire.on('test-success', (event) => {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message: event.message, type: 'success' }
        }));
    });

    $wire.on('test-failed', (event) => {
        window.dispatchEvent(new CustomEvent('toast', {
            detail: { message: event.message, type: 'error' }
        }));
    });
</script>
@endscript
