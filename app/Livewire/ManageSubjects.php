<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ManageSubjects extends Component
{
    public $subjects;
    public $selectedSubject;
    public $students;
    public $selectedStudents = [];
    public $showRemove = false;

    
    public function mount()
    {
        // Load all subjects assigned to the authenticated instructor
        $this->subjects = Subject::whereHas('instructors', function ($query) {
            $query->where('instructor_id', Auth::id());
        })->get();

        // Load all users with the role of 'student'
        $this->students = User::where('role', 'student')->get();
    }

    public function selectSubject($subjectId)
    {
        // Select a subject and fetch its students
        $this->selectedSubject = Subject::with(['students', 'instructors'])->find($subjectId);
        $this->showRemove = true;
        // Exclude already enrolled students from the list of available students
        $enrolledStudentIds = $this->selectedSubject->students->pluck('id')->toArray();
        $this->students = User::where('role', 'student')
                              ->whereNotIn('id', $enrolledStudentIds)
                              ->get();
    }

    public function enrollStudents()
    {
        $this->showRemove = true;


        if ($this->selectedSubject && !empty($this->selectedStudents)) {
            foreach ($this->selectedStudents as $studentId) {
                $this->selectedSubject->students()->syncWithoutDetaching($studentId);
            }

            session()->flash('success', 'Students successfully enrolled!');

            // Refresh the selected subject to include the new students
            $this->selectSubject($this->selectedSubject->id);
        }
    }

    public function removeStudent($studentId)
    {
        if ($this->selectedSubject) {
            // Ensure we detach the student only from the selected subject
            $this->selectedSubject->students()->detach($studentId);
    
            session()->flash('success', 'Student successfully removed!');
    
            // Refresh the selected subject to update the list of students
            $this->selectSubject($this->selectedSubject->id);
        }
    }
    

    public function render()
    {
        return view('livewire.manage-subjects', [
            'subjects' => $this->subjects,
        ]);
    }
}
