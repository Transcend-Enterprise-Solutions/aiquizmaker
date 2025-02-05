<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentQuizzes extends Component
{
    public $subjects; // Declare $subjects as a public property

    public function mount()
    {
        $now = Carbon::now(); // Use 'Asia/Manila' timezone if configured in app.php

        // Fetch subjects with quizzes for the current user
        $this->subjects = Auth::user()
            ->enrolledSubjects()
            ->with(['quizLists' => function ($query) use ($now) {
                $query->where('start_date', '<=', $now)
                      ->where('end_date', '>=', $now);
            }])
            ->get();
    }

    public function render()
    {
        // Pass the subjects to the view
        return view('livewire.student.student-quizzes', [
            'subjects' => $this->subjects,
        ]);
    }
}
