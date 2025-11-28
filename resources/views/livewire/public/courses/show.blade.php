<div>
    <!-- Course Header -->
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <div class="flex-1">
                    <div class="text-sm font-medium text-primary-400 mb-2">
                        {{ $course->category->name ?? 'General' }}
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold mb-4">
                        {{ $course->title }}
                    </h1>
                    <p class="text-lg text-gray-300 mb-6">
                        {{ $course->short_description }}
                    </p>
                    
                    <div class="flex items-center gap-6 text-sm">
                        <div class="flex items-center">
                            <span class="text-yellow-400 font-bold mr-1">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</span>
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($course->reviews()->avg('rating')) ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-gray-400">({{ $course->reviews()->count() }} ratings)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            {{ $course->enrollments()->count() }} students
                        </div>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Last updated {{ $course->updated_at->format('M Y') }}
                        </div>
                    </div>

                    <div class="mt-6 flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold">
                                {{ substr($course->instructor->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">
                                Created by {{ $course->instructor->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Main Content -->
            <div class="flex-1">
                <!-- What you'll learn -->
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Description</h2>
                    <div class="prose dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($course->description)) !!}
                    </div>
                </div>

                <!-- Curriculum -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Course Content</h2>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($course->sections as $section)
                            <div x-data="{ open: false }" class="border-b border-gray-200 dark:border-gray-700 last:border-0">
                                <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $section->title }}</span>
                                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span class="mr-4">{{ $section->lessons->count() }} lessons</span>
                                        <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </button>
                                <div x-show="open" class="px-6 py-2 bg-white dark:bg-gray-800">

                <!-- Instructor -->
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Instructor</h2>
                    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="h-16 w-16 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 text-2xl font-bold">
                                    {{ substr($course->instructor->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-6">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $course->instructor->name }}</h3>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">Instructor</p>
                                <div class="prose dark:prose-invert text-sm text-gray-600 dark:text-gray-300">
                                    {{ $course->instructor->bio ?? 'No bio available.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Reviews</h2>
                    <div class="space-y-4">
                        @forelse($course->reviews as $review)
                            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center mb-4">
                                    <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <div class="ml-3">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $review->user->name }}</div>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="ml-auto text-sm text-gray-500 dark:text-gray-400">
                                        {{ $review->created_at->diffForHumans() }}
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 dark:text-gray-400">No reviews yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-1">
                            @if($course->thumbnail)
                                <img class="w-full rounded-t-lg" src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}">
                            @else
</div>
