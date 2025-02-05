<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\QuizList;
use App\Models\Quiz;
use Carbon\Carbon;

class StudentTakeQuiz extends Component
{
    public $quizzes; // To store available quizzes
    public $currentQuiz; // To store the quiz being taken
    public $questions; // To store questions for the current quiz
    public $showQuiz = false; // To toggle quiz display
    public $answers = []; // To store student answers

    public function mount($subjectId)
    {
        // Fetch quizzes within the valid timeframe
        $this->quizzes = QuizList::where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('subject_id', 2) // Ensure subject_id matches the current subject
            ->get();
        
    }
    

    public function startQuiz($quizId)
    {
        $this->currentQuiz = QuizList::findOrFail($quizId);
        $this->questions = Quiz::where('quiz_id', $quizId)->get();
        $this->showQuiz = true;
    }

    public function submitAnswers()
    {
        // Save the student's answers (logic for saving to the database goes here)
        foreach ($this->questions as $question) {
            // Example of saving answers:
            // StudentQuizAttempt::create([
            //     'student_id' => Auth::id(),
            //     'quiz_id' => $this->currentQuiz->quiz_id,
            //     'question_id' => $question->id,
            //     'answer' => $this->answers[$question->id] ?? null,
            // ]);

            // Here you'd validate and save the data to a `student_quiz_attempts` table or similar.
        }

        // Reset the component state
        $this->reset(['currentQuiz', 'questions', 'showQuiz', 'answers']);
        session()->flash('success', 'Your answers have been submitted successfully!');
    }

    public function render()
    {
        return view('livewire.student.take-quiz');
    }
}
