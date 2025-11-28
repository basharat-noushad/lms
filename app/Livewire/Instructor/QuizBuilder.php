<?php

namespace App\Livewire\Instructor;

use App\Models\Course;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Section;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class QuizBuilder extends Component
{
    use AuthorizesRequests;

    public $course;
    public $section;
    public $quiz;
    public $questions = [];
    
    // Quiz Form
    public $title;
    public $description;
    public $time_limit;
    public $passing_score = 70;

    // Question Form
    public $showQuestionForm = false;
    public $editingQuestionId = null;
    public $questionContent;
    public $questionType = 'multiple_choice';
    public $questionPoints = 1;
    public $questionExplanation;
    
    // Answers Form
    public $answers = [
        ['content' => '', 'is_correct' => false],
        ['content' => '', 'is_correct' => false],
        ['content' => '', 'is_correct' => false],
        ['content' => '', 'is_correct' => false],
    ];

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'time_limit' => 'nullable|integer|min:1',
        'passing_score' => 'required|integer|min:0|max:100',
    ];

    public function mount(Course $course, Section $section, Quiz $quiz = null)
    {
        $this->authorize('update', $course);
        
        $this->course = $course;
        $this->section = $section;
        
        if ($quiz) {
            $this->quiz = $quiz;
            $this->title = $quiz->title;
            $this->description = $quiz->description;
            $this->time_limit = $quiz->time_limit_minutes;
            $this->passing_score = $quiz->passing_score;
            $this->loadQuestions();
        }
    }

    public function loadQuestions()
    {
        if ($this->quiz) {
            $this->questions = $this->quiz->questions()->with('answers')->get();
        }
    }

    public function saveQuiz()
    {
        $this->validate();

        if ($this->quiz) {
            $this->quiz->update([
                'title' => $this->title,
                'description' => $this->description,
                'time_limit_minutes' => $this->time_limit,
                'passing_score' => $this->passing_score,
            ]);
        } else {
            $this->quiz = Quiz::create([
                'course_id' => $this->course->id,
                'section_id' => $this->section->id,
                'title' => $this->title,
                'description' => $this->description,
                'time_limit_minutes' => $this->time_limit,
                'passing_score' => $this->passing_score,
            ]);
        }

        session()->flash('message', 'Quiz saved successfully.');
    }

    public function addQuestion()
    {
        $this->resetQuestionForm();
        $this->showQuestionForm = true;
    }

    public function editQuestion($questionId)
    {
        $question = Question::with('answers')->find($questionId);
        $this->editingQuestionId = $question->id;
        $this->questionContent = $question->content;
        $this->questionType = $question->type;
        $this->questionPoints = $question->points;
        $this->questionExplanation = $question->explanation;
        
        $this->answers = $question->answers->map(function($answer) {
            return [
                'id' => $answer->id,
                'content' => $answer->content,
                'is_correct' => $answer->is_correct,
            ];
        })->toArray();
        
        // Ensure at least 4 answer slots for UI consistency
        while (count($this->answers) < 4) {
            $this->answers[] = ['content' => '', 'is_correct' => false];
        }

        $this->showQuestionForm = true;
    }

    public function saveQuestion()
    {
        $this->validate([
            'questionContent' => 'required|string',
            'questionType' => 'required|in:multiple_choice,true_false',
            'questionPoints' => 'required|integer|min:1',
            'answers.*.content' => 'required_if:questionType,multiple_choice|string',
        ]);

        // Validate at least one correct answer
        $hasCorrect = collect($this->answers)->contains('is_correct', true);
        if (!$hasCorrect) {
            $this->addError('answers', 'Please select at least one correct answer.');
            return;
        }

        if ($this->editingQuestionId) {
            $question = Question::find($this->editingQuestionId);
            $question->update([
                'content' => $this->questionContent,
                'type' => $this->questionType,
                'points' => $this->questionPoints,
                'explanation' => $this->questionExplanation,
            ]);
            
            // Update answers logic (simplified: delete all and recreate)
            $question->answers()->delete();
        } else {
            $question = $this->quiz->questions()->create([
                'content' => $this->questionContent,
                'type' => $this->questionType,
                'points' => $this->questionPoints,
                'explanation' => $this->questionExplanation,
            ]);
        }

        foreach ($this->answers as $answer) {
            if (!empty($answer['content'])) {
                $question->answers()->create([
                    'content' => $answer['content'],
                    'is_correct' => $answer['is_correct'],
                ]);
            }
        }

        $this->loadQuestions();
        $this->showQuestionForm = false;
        $this->resetQuestionForm();
    }

    public function deleteQuestion($questionId)
    {
        Question::destroy($questionId);
        $this->loadQuestions();
    }

    public function setCorrectAnswer($index)
    {
        foreach ($this->answers as $key => $answer) {
            $this->answers[$key]['is_correct'] = ($key === $index);
        }
    }

    public function resetQuestionForm()
    {
        $this->editingQuestionId = null;
        $this->questionContent = '';
        $this->questionType = 'multiple_choice';
        $this->questionPoints = 1;
        $this->questionExplanation = '';
        $this->answers = [
            ['content' => '', 'is_correct' => false],
            ['content' => '', 'is_correct' => false],
            ['content' => '', 'is_correct' => false],
            ['content' => '', 'is_correct' => false],
        ];
    }

    public function render()
    {
        return view('livewire.instructor.quiz-builder')
            ->layout('layouts.instructor');
    }
}
