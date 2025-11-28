<div>
    @section('header', 'Reviews')

    <div class="mb-6 flex items-center justify-between">
        <select wire:model.live="rating" class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            <option value="all">All Ratings</option>
            <option value="5">5 Stars</option>
            <option value="4">4 Stars</option>
            <option value="3">3 Stars</option>
            <option value="2">2 Stars</option>
            <option value="1">1 Star</option>
        </select>
    </div>

    <div class="space-y-4">
        @forelse($reviews as $review)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6">
            <div class="flex items-start justify-between">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold">
                            {{ substr($review->user->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</h4>
                            <span class="text-xs text-gray-500 dark:text-gray-400">on {{ $review->course->title }}</span>
                        </div>
                        <div class="flex items-center mt-1">
                            @foreach(range(1, 5) as $star)
                                <svg class="w-4 h-4 {{ $star <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }} fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endforeach
                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ $review->comment }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-12 text-center text-gray-500 dark:text-gray-400">
            No reviews found.
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $reviews->links() }}
    </div>
</div>
