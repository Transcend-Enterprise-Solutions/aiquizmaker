<?php

namespace App\Livewire;



use Livewire\Component;
use App\Models\Quiz;

class TakeQuiz extends Component
{
    public $questions;
    public $answers = [];
    public $submitted = false;
    public $score = 0;

    public function mount()
    {
        $this->questions = Quiz::all(); // Fetch all questions
    }

    public function submitQuiz()
    {
        $this->submitted = true;

        foreach ($this->questions as $index => $question) {
            if (isset($this->answers[$index]) && $this->answers[$index] == $question->correct_answer) {
                $this->score++;
            }
        }
    }

    public function render()
    {
        return view('livewire.take-quiz');
    }
}