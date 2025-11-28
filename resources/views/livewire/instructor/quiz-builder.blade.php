<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ $quiz ? 'Edit Quiz: ' . $quiz->title : 'Create New Quiz' }}
        </h1>
        <a href="{{ route('instructor.courses.curriculum', $course->id) }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
            Back to Curriculum
        </a>
    </div>

    <!-- Quiz Settings -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
        <h2 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Quiz Settings</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quiz Title</label>
                <input type="text" wire:model="title" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                <textarea wire:model="description" rows="3" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Time Limit (Minutes)</label>
                <input type="number" wire:model="time_limit" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Passing Score (%)</label>
                <input type="number" wire:model="passing_score" min="0" max="100" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            </div>
        </div>
        
        <div class="mt-6 flex justify-end">
            <button wire:click="saveQuiz" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                {{ $quiz ? 'Update Settings' : 'Create Quiz' }}
            </button>
        </div>
    </div>

    @if($quiz)
        <!-- Questions List -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Questions ({{ count($questions) }})</h2>
                <button wire:click="addQuestion" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Question
                </button>
            </div>

            <div class="space-y-4">
                @foreach($questions as $index => $q)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-center mb-2">
                                    <span class="font-bold text-gray-500 mr-3">Q{{ $index + 1 }}</span>
                                    <span class="px-2 py-1 text-xs rounded bg-gray-100 dark:bg-gray-600 text-gray-600 dark:text-gray-300 uppercase">
                                        {{ str_replace('_', ' ', $q->type) }}
                                    </span>
                                    <span class="ml-2 text-sm text-gray-500">{{ $q->points }} pts</span>
                                </div>
                                <p class="text-gray-900 dark:text-white font-medium">{{ $q->content }}</p>
                            </div>
                            <div class="flex items-center ml-4 space-x-2">
                                <button wire:click="editQuestion({{ $q->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button wire:click="deleteQuestion({{ $q->id }})" class="p-2 text-red-600 hover:bg-red-50 rounded-full" onclick="return confirm('Are you sure?')">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Question Modal/Form -->
    @if($showQuestionForm)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6">
                <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">
                    {{ $editingQuestionId ? 'Edit Question' : 'Add New Question' }}
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Question Text</label>
                        <textarea wire:model="questionContent" rows="2" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                        @error('questionContent') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Type</label>
                            <select wire:model.live="questionType" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <option value="multiple_choice">Multiple Choice</option>
                                <option value="true_false">True / False</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Points</label>
                            <input type="number" wire:model="questionPoints" min="1" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                        </div>
                    </div>

                    <!-- Answers -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Answers</label>
                        
                        @if($questionType === 'true_false')
                            <div class="space-y-2">
                                <div class="flex items-center p-3 border rounded-lg {{ $answers[0]['is_correct'] ? 'border-green-500 bg-green-50' : '' }}">
                                    <input type="radio" name="tf_answer" wire:click="$set('answers.0.is_correct', true); $set('answers.1.is_correct', false)" {{ $answers[0]['is_correct'] ? 'checked' : '' }} class="mr-3">
                                    <span>True</span>
                                    <input type="hidden" wire:model="answers.0.content" value="True">
                                </div>
                                <div class="flex items-center p-3 border rounded-lg {{ $answers[1]['is_correct'] ? 'border-green-500 bg-green-50' : '' }}">
                                    <input type="radio" name="tf_answer" wire:click="$set('answers.1.is_correct', true); $set('answers.0.is_correct', false)" {{ $answers[1]['is_correct'] ? 'checked' : '' }} class="mr-3">
                                    <span>False</span>
                                    <input type="hidden" wire:model="answers.1.content" value="False">
                                </div>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($answers as $index => $answer)
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="correct_answer" wire:click="setCorrectAnswer({{ $index }})" {{ $answer['is_correct'] ? 'checked' : '' }} class="mt-1">
                                        <input type="text" wire:model="answers.{{ $index }}.content" placeholder="Answer option {{ $index + 1 }}" class="flex-1 rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    </div>
                                @endforeach
                                <p class="text-xs text-gray-500 mt-1">Select the radio button for the correct answer.</p>
                            </div>
                        @endif
                        @error('answers') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Explanation (Optional)</label>
                        <textarea wire:model="questionExplanation" rows="2" class="w-full rounded-lg border-gray-300 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Explain why the answer is correct..."></textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button wire:click="$set('showQuestionForm', false)" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">Cancel</button>
                    <button wire:click="saveQuestion" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">Save Question</button>
                </div>
            </div>
        </div>
    @endif
</div>
