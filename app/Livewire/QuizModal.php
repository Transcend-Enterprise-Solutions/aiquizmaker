<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\QuizList;

class QuizModal extends Component
{
    public $quiz;

    // Listen for the 'openModal' event
    protected $listeners = ['openModal'];

    public function openModal($quizId)
    {
        // Fetch the quiz data based on the quizId
        $this->quiz = QuizList::with('quizzes')->find($quizId);
    }

    public function render()
    {
        return view('livewire.quiz-modal');
    }
}
