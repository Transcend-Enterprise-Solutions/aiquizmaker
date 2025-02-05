<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Quiz;
use App\Models\QuizList;
use App\Models\Subject; // Add the Subject model

class QuizUpload extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $quizName;
    public $quizDuration;
    public $quizSet;
    public $subject; // New property for selected subject
    public $showModal = false;
    public $startDate;
    public $endDate;

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

        // Insert quiz metadata into quiz_lists
        $quizList = QuizList::create([
            'user_id' => auth()->id(),
            'quiz_name' => $this->quizName,
            'duration' => $this->quizDuration,
            'quiz_set' => $this->quizSet,
            'subject_id' => $this->subject, // Save the subject association
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ]);

        // Process the CSV file
        if (($handle = fopen($this->csvFile->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle); // Skip the header row
            while ($row = fgetcsv($handle)) {
                Quiz::create([
                    'quiz_id' => $quizList->quiz_id,
                    'user_id' => auth()->id(),
                    'question' => $row[0] ?? '',
                    'option' => json_encode([
                        $row[1] ?? null,
                        $row[2] ?? null,
                        $row[3] ?? null,
                        $row[4] ?? null,
                    ]),
                    'correct_answer' => $row[5] ?? '',
                ]);
            }
            fclose($handle);
        }

        toastr()->success('Quiz uploaded successfully!');
        $this->reset(['csvFile', 'quizName', 'quizDuration', 'quizSet', 'subject', 'startDate', 'endDate']);
        $this->showModal = false;
    }

    public function render()
    {
        return view('livewire.quiz-upload', [
            'quizzes' => QuizList::where('user_id', auth()->id())->with('quizzes')->get(),
            'subjects' => auth()->user()->subjects, // Get subjects via the relationship
        ]);
    }
    
}

