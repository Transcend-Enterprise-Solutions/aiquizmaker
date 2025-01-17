<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Quiz;

class QuizDetails extends Component
{
    public $quizId;
    public $quiz;

    public function mount($quizId = null)
    {
        if (!$quizId) {
            abort(404, 'Quiz not found');
        }
    
        $this->quizId = $quizId;
        $this->quiz = Quiz::with('quizzes')->findOrFail($quizId);
    }

    public function render()
    {
        return view('livewire.quiz-details', [
            'quiz' => $this->quiz,
        ]);
    }
}
