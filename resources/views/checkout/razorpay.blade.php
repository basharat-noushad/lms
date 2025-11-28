<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Complete Your Payment</h2>
                    
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Course:</strong> {{ $course->title }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Price:</strong> ₹{{ number_format($course->price, 2) }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-300"><strong>Order ID:</strong> {{ $order->order_number }}</p>
                    </div>

                    <form action="{{ route('checkout.callback', $order) }}" method="POST">
                        @csrf
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                                data-key="{{ $response['key'] }}"
                                data-amount="{{ $response['amount'] }}"
                                data-currency="{{ $response['currency'] }}"
                                data-order_id="{{ $response['id'] }}"
                                data-buttontext="Pay with Razorpay"
                                data-name="LearnHub LMS"
                                data-description="{{ $course->title }}"
                                data-prefill.name="{{ auth()->user()->name }}"
                                data-prefill.email="{{ auth()->user()->email }}"
                                data-theme.color="#6366f1">
                        </script>
                        <input type="hidden" custom="Hidden Element" name="hidden">
                    </form>

                    <div class="mt-4">
                        <a href="{{ route('courses.show', $course) }}" class="text-sm text-gray-600 hover:text-gray-900">
                            ← Cancel and go back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
