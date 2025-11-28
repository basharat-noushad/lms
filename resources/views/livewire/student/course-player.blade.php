<div class="flex gap-6 -mt-6 -mx-6 h-[calc(100vh-4rem)]">
    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Video/Content Player -->
        <div class="bg-black">
            @if($currentLesson->video_url)
                <div id="player-container" class="w-full aspect-video">
                    @if(str_contains($currentLesson->video_url, 'vimeo'))
                        <iframe src="{{ $currentLesson->video_url }}" 
                                class="w-full h-full"
                                frameborder="0" 
                                allow="autoplay; fullscreen; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    @elseif(str_contains($currentLesson->video_url, 'youtube') || str_contains($currentLesson->video_url, 'youtu.be'))
                        <iframe src="{{ $currentLesson->video_url }}" 
                                class="w-full h-full"
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                        </iframe>
                    @else
                        <video controls class="w-full h-full">
                            <source src="{{ $currentLesson->video_url }}" type="video/mp4">
                        </video>
                    @endif
                </div>
            @else
                <div class="w-full aspect-video flex items-center justify-center text-gray-400">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <p>No video available for this lesson</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Lesson Details -->
        <div class="flex-1 bg-white dark:bg-gray-800 p-6 overflow-y-auto">
            <div class="max-w-4xl">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $currentLesson->title }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $currentLesson->description }}</p>

                <!-- Navigation & Complete Button -->
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                    @if($this->getPreviousLesson())
                        <button wire:click="goToPreviousLesson" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Previous
                        </button>
                    @endif

                    @if(!$progress->completed)
                        <button wire:click="markAsCompleted" class="flex items-center px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Mark as Complete
                        </button>
                    @else
                        <div class="flex items-center px-4 py-2 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Completed
                        </div>
                    @endif

                    @if($this->getNextLesson())
                        <button wire:click="goToNextLesson" class="flex items-center px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition ml-auto">
                            Next
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @endif
                </div>

                @if($currentLesson->content)
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $currentLesson->content !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Curriculum Sidebar -->
    <div class="w-96 bg-white dark:bg-gray-800 border-l border-gray-200 dark:border-gray-700 overflow-y-auto flex flex-col">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="font-bold text-gray-900 dark:text-white mb-2">Course Content</h2>
            <div class="flex items-center justify-between text-sm">
                <span class="text-gray-600 dark:text-gray-400">{{ $enrollment->progress ?? 0 }}% Complete</span>
                <span class="text-gray-600 dark:text-gray-400">{{ $enrollment->lessonProgress()->where('completed', true)->count() }}/{{ $course->lessons()->count() }} Lessons</span>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                <div class="bg-primary-600 h-2 rounded-full transition-all" style="width: {{ $enrollment->progress ?? 0 }}%"></div>
            </div>
            
            @if($enrollment->progress == 100)
                <div class="mt-4">
                    <livewire:student.course-review :course="$course" />
                </div>
            @endif
        </div>

        <div class="divide-y divide-gray-200 dark:divide-gray-700 flex-1 overflow-y-auto">
            @foreach($sections as $section)
                <div x-data="{ open: {{ $section->lessons->contains('id', $currentLesson->id) ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between bg-gray-50 dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <span class="font-medium text-gray-900 dark:text-white">{{ $section->title }}</span>
                        <svg class="w-5 h-5 transform transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>

                    <div x-show="open" class="bg-white dark:bg-gray-800">
                        @foreach($section->lessons as $lesson)
                            @php
                                $lessonProgress = $enrollment->lessonProgress()
                                    ->where('lesson_id', $lesson->id)
                                    ->first();
                                $isCompleted = $lessonProgress && $lessonProgress->completed;
                            @endphp
                            <button wire:click="selectLesson({{ $lesson->id }})" 
                                    class="w-full px-6 py-3 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition {{ $currentLesson->id == $lesson->id ? 'bg-primary-50 dark:bg-primary-900/20' : '' }}">
                                <div class="flex-shrink-0 mr-3">
                                    @if($isCompleted)
                                        <div class="w-6 h-6 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @elseif($currentLesson->id == $lesson->id)
                                        <div class="w-6 h-6 rounded-full bg-primary-600"></div>
                                    @else
                                        <div class="w-6 h-6 rounded-full border-2 border-gray-300 dark:border-gray-600"></div>
                                    @endif
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white {{ $currentLesson->id == $lesson->id ? 'text-primary-600' : '' }}">
                                        {{ $lesson->title }}
                                    </div>
                                    @if($lesson->duration_minutes)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $lesson->duration_minutes }} min</div>
                                    @endif
                                </div>
                            </button>
                        @endforeach

                        @if($section->quiz)
                            <a href="{{ route('student.quiz.take', $section->quiz->id) }}" 
                               class="w-full px-6 py-3 flex items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition border-t border-gray-100 dark:border-gray-700">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        Quiz: {{ $section->quiz->title }}
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $section->quiz->questions->count() }} Questions
                                    </div>
                                </div>
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
