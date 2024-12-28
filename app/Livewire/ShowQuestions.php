<?php

namespace App\Livewire;

use Livewire\Component;

class ShowQuestions extends Component
{
    public $questions = [];

    public function mount()
    {
        // Retrieve the questions from the session
        $this->questions = session('questions', []);
    }

    public function getListeners()
    {
        return ['questionsUpdated' => 'refreshQuestions'];
    }

    public function refreshQuestions()
    {
        // Update the questions list when notified
        $this->questions = session('questions', []);
    }

    public function render()
    {
        return view('livewire.show-questions');
    }
}
