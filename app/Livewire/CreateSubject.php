<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateSubject extends Component
{
    public $name;
    public $description;
    public $subjects;
    public $instructors;
    public $selectedSubjectId;
    public $selectedInstructorId;
    public $showModal = false;
    public $showAssignModal = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'selectedInstructorId' => 'required|exists:users,id',
    ];

    public function mount()
    {
        $this->loadSubjects();
        $this->loadInstructors();
    }

    public function loadSubjects()
    {
        $this->subjects = Subject::all();
    }

    public function loadInstructors()
    {
        $this->instructors = User::where('role', 'instructor')->get(); // Fetch instructors based on 'role'
       
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Subject::create([
            'name' => $this->name,
            'description' => $this->description,
            'created_by' => auth()->id(),
        ]);

        $this->reset(['name', 'description']);
        $this->closeModal();
        toastr()->success('Subject created successfully!');
        $this->loadSubjects();
    }

    public function delete($subjectId)
    {
        $subject = Subject::find($subjectId);

        if ($subject) {
            $subject->delete();
            session()->flash('success', 'Subject deleted successfully!');
            $this->loadSubjects();
        } else {
            session()->flash('error', 'Subject not found!');
        }
    }

    public function openAssignModal($subjectId)
    {
        $this->selectedSubjectId = $subjectId;
        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->reset('selectedInstructorId'); // Reset the selected instructor
    }

    public function assign()
    {
        $this->validate([
            'selectedInstructorId' => 'required|exists:users,id',
            'selectedSubjectId' => 'required|exists:subjects,id',
        ]);

        // Check if the assignment already exists in the pivot table
        $exists = DB::table('instructor_subject')
            ->where('instructor_id', $this->selectedInstructorId)
            ->where('subject_id', $this->selectedSubjectId)
            ->exists();

        if (!$exists) {
            // Insert the assignment into the pivot table
            DB::table('instructor_subject')->insert([
                'instructor_id' => $this->selectedInstructorId,
                'subject_id' => $this->selectedSubjectId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            toastr()->success('Instructor assigned to subject successfully!');
        } else {
            toastr()->error('Instructor already assigned to subject!');
        }

        $this->closeAssignModal();
        $this->loadSubjects();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.admin.create-subject', [
            'subjects' => $this->subjects,
            'instructors' => $this->instructors,
        ]);
    }
}
