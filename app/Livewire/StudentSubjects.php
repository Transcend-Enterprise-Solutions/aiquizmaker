<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class StudentSubjects extends Component
{
    public function render()
    {
        return view('livewire.student-subjects', [
            'subjects' => Auth::user()->enrolledSubjects, // Fetch enrolled subjects for the logged-in student
        ]);
    }
}
