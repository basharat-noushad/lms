<?php

namespace App\Livewire\Student;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class QuizTaker extends Component
{
    public $quiz;
    public $currentQuestionIndex = 0;
    public $answers = []; // [question_id => answer_id]
    public $timeLeft; // in seconds
    public $isFinished = false;
    public $score = 0;
    public $passed = false;
    public $attempt;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz->load(['questions.answers']);
        
        // Check if already passed
        $lastAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('quiz_id', $quiz->id)
            ->latest()
            ->first();
            
        if ($lastAttempt && $lastAttempt->passed) {
            $this->isFinished = true;
            $this->score = $lastAttempt->score;
            $this->passed = true;
            $this->attempt = $lastAttempt;
        } else {
            $this->timeLeft = $quiz->time_limit_minutes * 60;
        }
    }

    public function selectAnswer($questionId, $answerId)
    {
        $this->answers[$questionId] = $answerId;
    }

    public function nextQuestion()
    {
        if ($this->currentQuestionIndex < $this->quiz->questions->count() - 1) {
            $this->currentQuestionIndex++;
        }
    }

    public function previousQuestion()
    {
        if ($this->currentQuestionIndex > 0) {
            $this->currentQuestionIndex--;
        }
    }

    public function submitQuiz()
    {
        $totalPoints = 0;
        $earnedPoints = 0;

        foreach ($this->quiz->questions as $question) {
            $totalPoints += $question->points;
            
            if (isset($this->answers[$question->id])) {
                $selectedAnswer = $question->answers->find($this->answers[$question->id]);
                if ($selectedAnswer && $selectedAnswer->is_correct) {
                    $earnedPoints += $question->points;
                }
            }
        }

        $percentage = ($totalPoints > 0) ? ($earnedPoints / $totalPoints) * 100 : 0;
        $passed = $percentage >= $this->quiz->passing_score;

        $this->attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $this->quiz->id,
            'score' => $percentage,
            'total_points' => $totalPoints,
            'passed' => $passed,
            'completed_at' => now(),
        ]);

        $this->score = $percentage;
        $this->passed = $passed;
        $this->isFinished = true;
    }

    public function retakeQuiz()
    {
        $this->reset(['currentQuestionIndex', 'answers', 'isFinished', 'score', 'passed', 'attempt']);
        $this->timeLeft = $this->quiz->time_limit_minutes * 60;
    }

    public function render()
    {
        return view('livewire.student.quiz-taker')
            ->layout('layouts.student');
    }
}
