<div>
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-primary-100 dark:bg-primary-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Enrolled Courses</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $enrolledCourses->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 dark:bg-green-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Completed</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $completedCourses->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Certificates</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $certificates->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Continue Learning -->
    @if($inProgressCourses->count() > 0)
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Continue Learning</h2>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($inProgressCourses->take(2) as $enrollment)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                        <div class="flex">
                            @if($enrollment->course->thumbnail)
                                <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="w-32 h-32 object-cover">
                            @else
                                <div class="w-32 h-32 bg-gradient-to-br from-primary-500 to-purple-600"></div>
                            @endif
                            <div class="flex-1 p-4">
                                <h3 class="font-semibold text-gray-900 dark:text-white mb-1">{{ $enrollment->course->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">by {{ $enrollment->course->instructor->name }}</p>
                                
                                <div class="mb-3">
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                        <span class="font-medium text-primary-600">{{ $enrollment->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('student.course.player', $enrollment->course->id) }}" class="inline-flex items-center text-sm font-medium text-primary-600 hover:text-primary-700">
                                    Continue Course
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- All Courses -->
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">My Courses</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($enrolledCourses as $enrollment)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    @if($enrollment->course->thumbnail)
                        <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}" alt="{{ $enrollment->course->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-purple-600"></div>
                    @endif
                    
                    <div class="p-4">
                        <div class="text-xs text-primary-600 font-medium mb-2">{{ $enrollment->course->category->name ?? 'General' }}</div>
                        <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">{{ $enrollment->course->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">by {{ $enrollment->course->instructor->name }}</p>
                        
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600 dark:text-gray-400">Progress</span>
                                <span class="font-medium text-primary-600">{{ $enrollment->progress ?? 0 }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-primary-600 h-2 rounded-full" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                            </div>
                        </div>

                        <a href="{{ route('student.course.player', $enrollment->course->id) }}" class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                            {{ $enrollment->progress == 100 ? 'Review Course' : 'Continue Learning' }}
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses yet</h3>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Start learning by enrolling in a course</p>
                    <a href="{{ route('courses.index') }}" class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Browse Courses
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
