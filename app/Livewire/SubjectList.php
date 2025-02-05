<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quiz;
use App\Models\QuizList;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;

class SubjectList extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedSubject = null;

    public function viewSubject($subjectId)
    {
        $this->selectedSubject = Subject::with('quizzes')->findOrFail($subjectId);
    
    }

    public function selectedSubject()
    {
        $this->emit('refreshChart', 
            $this->selectedSubject->quizzes->pluck('quiz_name'),
            $this->selectedSubject->quizzes->map(fn($quiz) => $quiz->studentResults->avg('score') ?? 0)
        );
        
    }

    public function getQuizData($quizId)
    {
        $quiz = QuizList::with(['questions', 'studentResults' => function ($query) use ($quizId) {
            $query->where('quiz_id', $quizId);
        }])->findOrFail($quizId);
    
        // Prepare data for the graph
        $questionStats = $quiz->questions->map(function ($question) use ($quiz) {
            $wrongAnswers = $quiz->studentResults->filter(function ($result) use ($question) {
                return $result->question_id === $question->id && !$result->is_correct;
            })->count();
    
            return [
                'question' => $question->text,
                'wrong_answers' => $wrongAnswers,
            ];
        });
    
        return view('quiz-stats', compact('quiz', 'questionStats'));
    }
    
    public function deleteSubject($subjectId)
    {
        Subject::findOrFail($subjectId)->delete();
        $this->resetPage();
    }

    public function render()
    {
        $subjects = Subject::query()
            ->whereHas('instructors', function ($query) {
                $query->where('instructor_id', Auth::id());
            })
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.subject-list', [
            'subjects' => $subjects,
        ]);
    }
}
