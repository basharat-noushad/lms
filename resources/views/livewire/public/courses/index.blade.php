<div class="min-h-screen bg-gray-50 dark:bg-gray-900 pb-20">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Explore Courses</h1>
            <p class="mt-2 text-gray-600 dark:text-gray-400">Discover new skills and advance your career with our expert-led courses.</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside class="w-full lg:w-72 flex-shrink-0">
                <div class="sticky top-24 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Filters</h2>
                        <button wire:click="$set('search', ''); $set('category', ''); $set('level', ''); $set('price', '');" class="text-xs font-semibold text-primary-600 hover:text-primary-700 uppercase tracking-wide">
                            Reset
                        </button>
                    </div>
                    
                    <div class="space-y-6">
                        <!-- Search -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                                </span>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="search"
                                    placeholder="Keywords..."
                                    class="w-full pl-10 rounded-xl border-gray-200 bg-gray-50 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white transition-shadow"
                                >
                            </div>
                        </div>

                        <!-- Categories -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                            <div class="space-y-2">
                                <label class="flex items-center group cursor-pointer">
                                    <input type="radio" wire:model.live="category" value="" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500 rounded-full">
                                    <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white transition-colors">All Categories</span>
                                </label>
                                @foreach($categories as $cat)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" wire:model.live="category" value="{{ $cat->id }}" class="h-4 w-4 border-gray-300 text-primary-600 focus:ring-primary-500 rounded-full">
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white transition-colors flex-1 flex justify-between">
                                            <span>{{ $cat->name }}</span>
                                            <span class="text-xs text-gray-400 bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full">{{ $cat->courses_count }}</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Level -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Level</label>
                            <select
                                wire:model.live="level"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-900 dark:text-white"
                            >
                                <option value="">All Levels</option>
                                <option value="beginner">Beginner</option>
                                <option value="intermediate">Intermediate</option>
                                <option value="advanced">Advanced</option>
                            </select>
                        </div>

                        <!-- Price -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price</label>
                            <div class="flex rounded-lg bg-gray-100 dark:bg-gray-900 p-1">
                                <button wire:click="$set('price', '')" class="flex-1 rounded-md py-1.5 text-xs font-medium transition-colors {{ $price === '' ? 'bg-white shadow text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">All</button>
                                <button wire:click="$set('price', 'free')" class="flex-1 rounded-md py-1.5 text-xs font-medium transition-colors {{ $price === 'free' ? 'bg-white shadow text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">Free</button>
                                <button wire:click="$set('price', 'paid')" class="flex-1 rounded-md py-1.5 text-xs font-medium transition-colors {{ $price === 'paid' ? 'bg-white shadow text-gray-900 dark:bg-gray-700 dark:text-white' : 'text-gray-500 hover:text-gray-900 dark:text-gray-400' }}">Paid</button>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Course Grid -->
            <main class="flex-1">
                @if($courses->count() > 0)
                <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">{{ $courses->firstItem() }}-{{ $courses->lastItem() }}</span> of {{ $courses->total() }} results</p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <select 
                            wire:model.live="sort" 
                            class="rounded-lg border-gray-200 bg-white py-1.5 pl-3 pr-8 text-sm focus:border-primary-500 focus:ring-primary-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        >
                            <option value="newest">Newest</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
                    @foreach($courses as $course)
                        <div class="group flex flex-col rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:border-primary-100 dark:hover:border-primary-900 transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                            <!-- Thumbnail -->
                            <a href="{{ route('courses.show', $course) }}" class="relative aspect-[4/3] overflow-hidden bg-gray-100 dark:bg-gray-900">
                                <img 
                                    src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                                    alt="{{ $course->title }}" 
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                                <div class="absolute top-4 left-4">
                                    <span class="inline-flex items-center rounded-lg bg-white/90 backdrop-blur-md px-2.5 py-1 text-xs font-semibold text-gray-900 shadow-sm">
                                        {{ $course->category->name ?? 'General' }}
                                    </span>
                                </div>
                            </a>

                            <!-- Content -->
                            <div class="flex flex-1 flex-col p-6">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center gap-1.5 text-yellow-400">
                                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</span>
                                        <span class="text-xs text-gray-400">({{ $course->reviews()->count() }})</span>
                                    </div>
                                </div>

                                <h3 class="text-lg font-bold text-gray-900 dark:text-white leading-tight mb-2 group-hover:text-primary-600 transition-colors">
                                    <a href="{{ route('courses.show', $course) }}">
                                        {{ $course->title }}
                                    </a>
                                </h3>

                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2 mb-6 flex-1">
                                    {{ Str::limit(strip_tags($course->description), 100) }}
                                </p>

                                <div class="flex items-center gap-3 mb-6">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex-shrink-0">
                                        <!-- Instructor Avatar Placeholder -->
                                    </div>
                                    <div class="text-xs">
                                        <p class="text-gray-500 dark:text-gray-400">Instructor</p>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ $course->instructor->name }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="text-xl font-bold text-primary-600">
                                        {{ $course->is_free ? 'Free' : '$' . number_format($course->price, 2) }}
                                    </div>
                                    <a href="{{ route('courses.show', $course) }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-primary-600 flex items-center gap-1 transition-colors">
                                        Details <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-12">
                    {{ $courses->links() }}
                </div>
                @else
                    <div class="flex flex-col items-center justify-center py-24 px-4 text-center rounded-3xl bg-white border border-gray-100 dark:bg-gray-800 dark:border-gray-700">
                        <div class="w-24 h-24 bg-gray-50 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">No courses found</h3>
                        <p class="text-gray-500 dark:text-gray-400 max-w-md mx-auto mb-8">We couldn't find any courses matching your criteria. Try adjusting your filters or search terms.</p>
                        <button wire:click="$set('search', ''); $set('category', ''); $set('level', ''); $set('price', '');" class="px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-full transition-colors shadow-lg shadow-primary-600/20">
                            Clear Filters
                        </button>
                    </div>
                @endif
            </main>
        </div>
    </div>
</div>
