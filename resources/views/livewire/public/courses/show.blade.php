<div class="bg-gray-50 dark:bg-gray-900 min-h-screen pb-20">
    <!-- Hero / Header -->
    <div class="relative bg-gray-900 pt-16 pb-32 overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-20 blur-sm" src="https://images.unsplash.com/photo-1513258496098-8830b3a98e19?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80" alt="Background">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <div class="flex items-center gap-2 mb-6">
                    <span class="inline-flex items-center rounded-full bg-primary-900/50 border border-primary-500/30 px-3 py-1 text-xs font-medium text-primary-300">
                        {{ $course->category->name ?? 'General' }}
                    </span>
                    @if($course->level)
                    <span class="inline-flex items-center rounded-full bg-gray-700/50 border border-gray-600 px-3 py-1 text-xs font-medium text-gray-300">
                        {{ ucfirst($course->level) }}
                    </span>
                    @endif
                </div>

                <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                    {{ $course->title }}
                </h1>

                <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                    {{ $course->short_description }}
                </p>

                <div class="flex flex-wrap items-center gap-8 text-sm font-medium text-gray-300">
                    <div class="flex items-center gap-2">
                        <div class="flex text-yellow-400">
                            <span class="text-white font-bold text-lg mr-2">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</span>
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= round($course->reviews()->avg('rating')) ? 'fill-current' : 'text-gray-600' }}" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="underline decoration-gray-500 decoration-1 underline-offset-4">({{ $course->reviews()->count() }} reviews)</span>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>{{ $course->enrollments()->count() }} students</span>
                    </div>

                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Last updated {{ $course->updated_at->format('M Y') }}</span>
                    </div>
                </div>

                <div class="mt-8 flex items-center gap-4">
                    <img class="h-12 w-12 rounded-full ring-2 ring-white/10" src="https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=random" alt="{{ $course->instructor->name }}">
                    <div>
                        <p class="text-sm text-gray-400">Created by</p>
                        <p class="text-white font-semibold">{{ $course->instructor->name }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-20 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <!-- Left Column: Content -->
            <div class="lg:col-span-2 space-y-8">

                <!-- What you'll learn (Placeholder for future feature, but good for layout) -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">About this course</h2>
                    <div class="prose prose-lg dark:prose-invert max-w-none text-gray-600 dark:text-gray-300">
                        {!! nl2br(e($course->description)) !!}
                    </div>
                </div>

                <!-- Curriculum -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Course Content</h2>
                    <div class="space-y-4">
                        @foreach($course->sections as $section)
                            <div x-data="{ open: false }" class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden">
                                <button @click="open = !open" class="w-full flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                        <span class="font-semibold text-gray-900 dark:text-white text-left">{{ $section->title }}</span>
                                    </div>
                                    <span class="text-xs text-gray-500 font-medium">{{ $section->lessons->count() }} lessons</span>
                                </button>
                                <div x-show="open" class="divide-y divide-gray-100 dark:divide-gray-700 border-t border-gray-200 dark:border-gray-700">
                                    @foreach($section->lessons as $lesson)
                                        <div class="p-3 pl-12 flex items-center justify-between bg-white dark:bg-gray-800">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                <span class="text-sm text-gray-600 dark:text-gray-300">{{ $lesson->title }}</span>
                                            </div>
                                            @if($lesson->is_free)
                                                <span class="text-xs font-semibold text-green-600 bg-green-50 px-2 py-0.5 rounded">Preview</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Instructor -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Your Instructor</h2>
                    <div class="flex flex-col sm:flex-row gap-6">
                        <img class="h-24 w-24 rounded-2xl object-cover shadow-md" src="https://ui-avatars.com/api/?name={{ urlencode($course->instructor->name) }}&background=random&size=128" alt="{{ $course->instructor->name }}">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $course->instructor->name }}</h3>
                            <p class="text-primary-600 font-medium mb-3">Senior Instructor</p>
                            <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                                {{ $course->instructor->bio ?? 'Passionate educator with over 10 years of experience in the field. Dedicated to helping students achieve their goals through practical, hands-on learning.' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Reviews -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Student Feedback</h2>
                    <div class="space-y-6">
                        @forelse($course->reviews as $review)
                            <div class="border-b border-gray-100 dark:border-gray-700 pb-6 last:border-0 last:pb-0">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center font-bold text-gray-500">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white text-sm">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500 dark:text-gray-400">No reviews yet. Be the first to review!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Column: Sticky Sidebar -->
            <div class="lg:col-span-1">
                <div class="sticky top-24">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-700">
                        <!-- Video Preview / Thumbnail -->
                        <div class="relative aspect-video bg-gray-900 cursor-pointer group">
                             <img
                                src="{{ $course->thumbnail ? Storage::url($course->thumbnail) : 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}"
                                alt="{{ $course->title }}"
                                class="w-full h-full object-cover group-hover:opacity-75 transition-opacity"
                            >
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-gray-900 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                            <div class="absolute bottom-4 left-0 right-0 text-center">
                                <span class="text-white font-bold text-sm drop-shadow-md">Preview this course</span>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="mb-6">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $course->is_free ? 'Free' : '$' . number_format($course->price, 2) }}</span>
                                    @if(!$course->is_free)
                                        <span class="text-lg text-gray-400 line-through decoration-gray-400">${{ number_format($course->price * 1.5, 2) }}</span>
                                    @endif
                                </div>
                                @if(!$course->is_free)
                                    <div class="inline-flex items-center gap-1 text-red-600 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded text-xs font-bold uppercase">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Limited time offer</span>
                                    </div>
                                @endif
                            </div>

                            @auth
                                @if(auth()->user()->hasPurchased($course))
                                    <a href="#" class="block w-full text-center py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-green-600/30 mb-4">
                                        Continue Learning
                                    </a>
                                @else
                                    <a href="{{ route('checkout', $course) }}" class="block w-full text-center py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-600/30 mb-4 transform hover:-translate-y-1">
                                        {{ $course->is_free ? 'Enroll Now' : 'Buy Now' }}
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full text-center py-4 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-primary-600/30 mb-4">
                                    Log in to Enroll
                                </a>
                            @endauth

                            <p class="text-xs text-center text-gray-500 mb-6">30-Day Money-Back Guarantee</p>

                            <div class="space-y-4">
                                <h4 class="font-bold text-gray-900 dark:text-white">This course includes:</h4>
                                <ul class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        <span>{{ $course->sections->sum(fn($s) => $s->lessons->count()) }} video lessons</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span>Access on mobile and TV</span>
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>Certificate of completion</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
