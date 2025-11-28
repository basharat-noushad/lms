<div>
    <!-- Header with Search and Filters -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">My Courses</h1>
        
        <div class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       placeholder="Search courses..."
                       class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Filter -->
            <select wire:model.live="filter" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                <option value="all">All Courses</option>
                <option value="in-progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>

            <!-- Sort -->
            <select wire:model.live="sortBy" 
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                <option value="recent">Most Recent</option>
                <option value="title">Title (A-Z)</option>
                <option value="progress">Progress</option>
            </select>
        </div>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($enrollments as $enrollment)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                <!-- Thumbnail -->
                <div class="relative">
                    @if($enrollment->course->thumbnail)
                        <img src="{{ asset('storage/' . $enrollment->course->thumbnail) }}" 
                             alt="{{ $enrollment->course->title }}" 
                             class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-primary-500 to-purple-600"></div>
                    @endif
                    
                    <!-- Progress Badge -->
                    @if($enrollment->progress == 100)
                        <div class="absolute top-2 right-2 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                            Completed
                        </div>
                    @elseif($enrollment->progress > 0)
                        <div class="absolute top-2 right-2 px-3 py-1 bg-primary-500 text-white text-xs font-bold rounded-full">
                            {{ $enrollment->progress }}%
                        </div>
                    @endif
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <div class="text-xs text-primary-600 font-medium mb-2">
                        {{ $enrollment->course->category->name ?? 'General' }}
                    </div>
                    
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 h-12">
                        {{ $enrollment->course->title }}
                    </h3>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        by {{ $enrollment->course->instructor->name }}
                    </p>
                    
                    <!-- Progress Bar -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-600 dark:text-gray-400">Progress</span>
                            <span class="font-medium text-primary-600">{{ $enrollment->progress ?? 0 }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-primary-600 h-2 rounded-full transition-all" 
                                 style="width: {{ $enrollment->progress ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('student.course.player', $enrollment->course->id) }}" 
                           class="flex-1 text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition text-sm font-medium">
                            {{ $enrollment->progress == 100 ? 'Review' : 'Continue' }}
                        </a>
                        
                        @if($enrollment->certificate)
                            <a href="{{ route('student.certificate.download', $enrollment->certificate->id) }}" 
                               class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm"
                               title="Download Certificate">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No courses found</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">
                    @if($search)
                        Try adjusting your search or filters
                    @else
                        Start learning by enrolling in a course
                    @endif
                </p>
                @if(!$search)
                    <a href="{{ route('courses.index') }}" 
                       class="inline-block px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Browse Courses
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($enrollments->hasPages())
        <div class="mt-6">
            {{ $enrollments->links() }}
        </div>
    @endif
</div>
