<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Quiz;
use App\Models\QuizList;
use App\Models\Subject;
use Illuminate\Support\Facades\Storage; // Required for handling file uploads
use Illuminate\Support\Facades\Hash;



class QuizUpload extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $quizName;
    public $quizDuration;
    public $quizSet;
    public $subject;
    public $showModal = false;
    public $startDate;
    public $endDate;

    public $confirmDeleteModal = false; // New property to show confirmation modal
    public $quizToDelete; // Stores the ID of the quiz being deleted
    public $password; // User-entered password for confirmation
    public $searchTerm = '';

    public function uploadQuiz()
    {
        // Validate form inputs
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:2048',
            'quizName' => 'required|string|max:255',
            'quizDuration' => 'required|integer|min:1',
            'quizSet' => 'required|string|max:255',
            'subject' => 'required|exists:subjects,id',
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',
        ]);

        // Save file temporarily
        $filePath = $this->csvFile->store('uploads');

        // Insert quiz metadata into quiz_lists
        $quizList = QuizList::create([
            'user_id' => auth()->id(),
            'quiz_name' => $this->quizName,
            'duration' => $this->quizDuration,
            'quiz_set' => $this->quizSet,
            'subject_id' => $this->subject,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        // Process the CSV file
        if (($handle = fopen(Storage::path($filePath), 'r')) !== false) {
            $header = fgetcsv($handle); // Skip the header row
            while ($row = fgetcsv($handle)) {
                Quiz::create([
                    'quiz_id' => $quizList->quiz_id,
                    'user_id' => auth()->id(),
                    'question' => $row[0] ?? '',
                    'option' => json_encode(array_values(array_filter([
                        $row[1] ?? null,
                        $row[2] ?? null,
                        $row[3] ?? null,
                        $row[4] ?? null,
                    ], fn($value) => !is_null($value) && $value !== ''))), // Remove empty values
                    'correct_answer' => $row[5] ?? '',
                ]);
                
            }
            fclose($handle);
        }

        // Delete the file after processing
        Storage::delete($filePath);

        session()->flash('success', 'Quiz uploaded successfully!');
        $this->reset(['csvFile', 'quizName', 'quizDuration', 'quizSet', 'subject', 'startDate', 'endDate']);
        $this->showModal = false;
    }

    public function confirmDelete($quizId)
    {
        $this->quizToDelete = $quizId;
        $this->confirmDeleteModal = true; // Show the confirmation modal
    }

    public function deleteQuiz()
    {
        // Validate password input
        $this->validate([
            'password' => 'required|string',
        ]);

        // ✅ Check the user's password
        if (!Hash::check($this->password, auth()->user()->password)) {
            toastr()->error('Incorrect password.');
            return;
        }

        // Find and delete the quiz
        $quizList = QuizList::where('user_id', auth()->id())->where('quiz_id', $this->quizToDelete)->first();

        if (!$quizList) {
            session()->flash('error', 'Quiz not found.');
            return;
        }

        $quizList->delete();

        // Reset properties
        $this->confirmDeleteModal = false;
        $this->quizToDelete = null;
        $this->password = '';

        toastr()->success('Quiz deleted successfully.');
    }

    public function render()
    {
        
        return view('livewire.quiz-upload', [
            'quizzes' => QuizList::where('user_id', auth()->id())->with('quizzes')->get(),
            'subjects' => auth()->user()->subjects,
        ]);
    }
}
