<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Wishlist</h1>
        <p class="text-gray-500 dark:text-gray-400">Saved courses you want to take</p>
    </div>

    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($wishlistItems as $item)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition group">
                    <div class="relative">
                        @if($item->course->thumbnail)
                            <img src="{{ asset('storage/' . $item->course->thumbnail) }}" 
                                 alt="{{ $item->course->title }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-purple-600"></div>
                        @endif
                        
                        <button wire:click="removeFromWishlist({{ $item->course->id }})" 
                                class="absolute top-2 right-2 p-2 bg-white rounded-full shadow hover:bg-red-50 text-red-500 transition"
                                title="Remove from Wishlist">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="p-4">
                        <div class="text-xs text-primary-600 font-medium mb-2">
                            {{ $item->course->category->name ?? 'General' }}
                        </div>
                        
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 h-12">
                            <a href="{{ route('courses.show', $item->course->slug) }}" class="hover:text-primary-600">
                                {{ $item->course->title }}
                            </a>
                        </h3>
                        
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                            by {{ $item->course->instructor->name }}
                        </p>
                        
                        <div class="flex items-center justify-between mt-4">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $item->course->price > 0 ? '$' . number_format($item->course->price, 2) : 'Free' }}
                            </span>
                            
                            <a href="{{ route('courses.show', $item->course->slug) }}" 
                               class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm font-medium">
                                View Course
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $wishlistItems->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Your wishlist is empty</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Save courses you're interested in to view them later.</p>
            <a href="{{ route('courses.index') }}" 
               class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                Browse Courses
            </a>
        </div>
    @endif
</div>
