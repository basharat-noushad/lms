<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
        {{ $existingReview ? 'Your Review' : 'Write a Review' }}
    </h3>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <!-- Rating -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
            <div class="flex items-center space-x-1">
                @for($i = 1; $i <= 5; $i++)
                    <button type="button" 
                            wire:click="$set('rating', {{ $i }})"
                            class="focus:outline-none transition-colors duration-200">
                        <svg class="w-8 h-8 {{ $rating >= $i ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}" 
                             fill="currentColor" 
                             viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </button>
                @endfor
            </div>
            @error('rating') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Comment -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Review</label>
            <textarea wire:model="comment" 
                      rows="4" 
                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary-500 focus:border-primary-500"
                      placeholder="Share your experience with this course..."></textarea>
            @error('comment') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" 
                class="w-full px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition font-medium">
            {{ $existingReview ? 'Update Review' : 'Submit Review' }}
        </button>
    </form>
</div>
