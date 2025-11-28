<div class="max-w-4xl mx-auto py-8 px-4">
    @if(!$isFinished)
        <!-- Quiz Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $quiz->title }}</h1>
                <div class="text-lg font-mono font-bold {{ $timeLeft < 60 ? 'text-red-600' : 'text-gray-700 dark:text-gray-300' }}"
                     x-data="{ time: {{ $timeLeft }} }"
                     x-init="setInterval(() => { if(time > 0) time--; else $wire.submitQuiz() }, 1000)">
                    <span x-text="Math.floor(time / 60).toString().padStart(2, '0')"></span>:
                    <span x-text="(time % 60).toString().padStart(2, '0')"></span>
                </div>
            </div>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                <div class="bg-primary-600 h-2 rounded-full transition-all duration-500"
                     style="width: {{ (($currentQuestionIndex + 1) / $quiz->questions->count()) * 100 }}%"></div>
            </div>
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400 text-right">
                Question {{ $currentQuestionIndex + 1 }} of {{ $quiz->questions->count() }}
            </div>
        </div>

        <!-- Question Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
            <div class="mb-6">
                <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 rounded text-sm font-medium mb-4">
                    {{ $quiz->questions[$currentQuestionIndex]->points }} Points
                </span>
                <h2 class="text-xl text-gray-900 dark:text-white font-medium">
                    {{ $quiz->questions[$currentQuestionIndex]->content }}
                </h2>
            </div>

            <div class="space-y-4">
                @foreach($quiz->questions[$currentQuestionIndex]->answers as $answer)
                    <button wire:click="selectAnswer({{ $quiz->questions[$currentQuestionIndex]->id }}, {{ $answer->id }})"
                            class="w-full text-left p-4 rounded-lg border-2 transition-all {{ isset($answers[$quiz->questions[$currentQuestionIndex]->id]) && $answers[$quiz->questions[$currentQuestionIndex]->id] == $answer->id ? 'border-primary-600 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-primary-300' }}">
                        <span class="text-gray-900 dark:text-white">{{ $answer->content }}</span>
                    </button>
                @endforeach
            </div>

            <div class="mt-8 flex justify-between">
                <button wire:click="previousQuestion" 
                        class="px-6 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 disabled:opacity-50"
                        {{ $currentQuestionIndex === 0 ? 'disabled' : '' }}>
                    Previous
                </button>

                @if($currentQuestionIndex === $quiz->questions->count() - 1)
                    <button wire:click="submitQuiz" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition"
                            onclick="return confirm('Are you sure you want to submit?')">
                        Submit Quiz
                    </button>
                @else
                    <button wire:click="nextQuestion" 
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Next
                    </button>
                @endif
            </div>
        </div>
    @else
        <!-- Results -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-8 text-center max-w-2xl mx-auto">
            <div class="mb-6">
                @if($passed)
                    <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-green-600 mb-2">Congratulations!</h2>
                    <p class="text-gray-600 dark:text-gray-300">You passed the quiz.</p>
                @else
                    <div class="w-20 h-20 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-red-600 mb-2">Keep Trying!</h2>
                    <p class="text-gray-600 dark:text-gray-300">You didn't reach the passing score.</p>
                @endif
            </div>

            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Score</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ round($score) }}%</div>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Points</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $attempt->total_points }}</div>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-sm text-gray-500 dark:text-gray-400">Passing Score</div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $quiz->passing_score }}%</div>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('student.course.player', $quiz->course_id) }}" 
                   class="px-6 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Back to Course
                </a>
                @if(!$passed)
                    <button wire:click="retakeQuiz" 
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                        Retake Quiz
                    </button>
                @endif
            </div>
        </div>
    @endif
</div>
