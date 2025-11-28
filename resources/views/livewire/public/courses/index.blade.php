<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Sidebar Filters -->
            <aside class="w-full flex-shrink-0 lg:w-64">
                <div class="sticky top-4 rounded-lg border border-gray-200 bg-white p-5 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Filters</h2>
                        <button wire:click="$set('search', ''); $set('category', ''); $set('level', ''); $set('price', '');" class="text-sm font-medium text-primary-600 hover:text-primary-700 dark:text-primary-400">
                            Clear
                        </button>
                    </div>
                    
                    <!-- Search -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Search Courses</label>
                        <input 
                            type="text" 
                            wire:model.live.debounce.300ms="search" 
                            placeholder="Search..." 
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                    </div>

                    <!-- Categories -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                        <select 
                            wire:model.live="category" 
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }} ({{ $cat->courses_count }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Level -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Level</label>
                        <select 
                            wire:model.live="level" 
                            class="w-full rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="">All Levels</option>
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-300">Price</label>
                        <div class="space-y-2">
                            <label class="flex cursor-pointer items-center">
                                <input type="radio" wire:model.live="price" value="" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">All</span>
                            </label>
                            <label class="flex cursor-pointer items-center">
                                <input type="radio" wire:model.live="price" value="free" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Free</span>
                            </label>
                            <label class="flex cursor-pointer items-center">
                                <input type="radio" wire:model.live="price" value="paid" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Paid</span>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Course Grid -->
            <main class="flex-1">
                @if($courses->count() > 0)
                <!-- Header -->
                <div class="mb-6 flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">All Courses</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $courses->total() }} courses available</p>
                    </div>
                    <div>
                        <select 
                            wire:model.live="sort" 
                            class="rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                        >
                            <option value="newest">Most Recent</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <!-- Course Cards -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach($courses as $course)
                        <div class="group overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md dark:border-gray-700 dark:bg-gray-800">
                            <!-- Course Image -->
                            <a href="{{ route('courses.show', $course) }}" class="relative block aspect-video overflow-hidden bg-gray-200 dark:bg-gray-700">
                                <img 
                                    src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : asset('images/course-placeholder.jpg') }}" 
                                    alt="{{ $course->title }}" 
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                                >
                                @if($course->is_featured)
                                    <span class="absolute left-3 top-3 rounded bg-yellow-400 px-2 py-1 text-xs font-semibold text-yellow-900">
                                        Bestseller
                                    </span>
                                @endif
                            </a>
                            
                            <!-- Course Content -->
                            <div class="p-4">
                                <!-- Category Badge -->
                                <div class="mb-2">
                                    <span class="inline-block rounded bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 dark:bg-primary-900/30 dark:text-primary-400">
                                        {{ $course->category->name ?? 'General' }}
                                    </span>
                                </div>

                                <!-- Title -->
                                <a href="{{ route('courses.show', $course) }}">
                                    <h3 class="mb-2 line-clamp-2 text-base font-semibold text-gray-900 hover:text-primary-600 dark:text-white dark:hover:text-primary-400">
                                        {{ $course->title }}
                                    </h3>
                                </a>

                                <!-- Instructor -->
                                <p class="mb-3 text-xs text-gray-600 dark:text-gray-400">
                                    {{ $course->instructor->name }}
                                </p>

                                <!-- Description -->
                                <p class="mb-3 line-clamp-2 text-sm text-gray-600 dark:text-gray-400">
                                    {{ Str::limit(strip_tags($course->description), 80) }}
                                </p>

                                <!-- Rating & Level -->
                                <div class="mb-3 flex items-center gap-3 text-xs">
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-gray-500 dark:text-gray-400">({{ $course->reviews()->count() }})</span>
                                    </div>
                                    @if($course->level)
                                    <span class="text-gray-500 dark:text-gray-400">• {{ ucfirst($course->level) }}</span>
                                    @endif
                                </div>

                                <!-- Price & CTA -->
                                <div class="flex items-center justify-between border-t border-gray-100 pt-3 dark:border-gray-700">
                                    <div class="text-lg font-bold text-gray-900 dark:text-white">
                                        {{ $course->is_free ? 'Free' : '$' . number_format($course->price, 2) }}
                                    </div>
                                    <a 
                                        href="{{ route('courses.show', $course) }}" 
                                        class="rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2"
                                    >
                                        View Course
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
                @else
                    <!-- Empty State -->
                    <div class="rounded-lg border border-gray-200 bg-white p-12 text-center shadow-sm dark:border-gray-700 dark:bg-gray-800">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900 dark:text-white">No courses found</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Try adjusting your filters or search terms</p>
                        <button 
                            wire:click="$set('search', ''); $set('category', ''); $set('level', ''); $set('price', '');" 
                            class="mt-6 rounded-md bg-primary-600 px-4 py-2 text-sm font-medium text-white hover:bg-primary-700"
                        >
                            Clear All Filters
                        </button>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
