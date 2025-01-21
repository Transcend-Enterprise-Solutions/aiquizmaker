<?php

namespace App\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Quiz;
use App\Models\QuizList;

class QuizUpload extends Component
{
    use WithFileUploads;

    public $csvFile;
    public $quizName;
    public $quizDuration;
    public $quizSet;
    public $showModal = false;
    public $startDate;
    public $endDate;


    public function uploadQuiz()
    {

        // Validate the form inputs
        $this->validate([
            'csvFile' => 'required|file|mimes:csv,txt|max:2048',
            'quizName' => 'required|string|max:255',
            'quizDuration' => 'required|integer|min:1',
            'quizSet' => 'required|string|max:255',
            'startDate' => 'required|date|before:endDate',
            'endDate' => 'required|date|after:startDate',
        ]);
    
        // Insert quiz metadata into quiz_lists
        $quizList = QuizList::create([
            'user_id' => auth()->id(),
            'quiz_name' => $this->quizName,
            'duration' => $this->quizDuration,
            'quiz_set' => $this->quizSet,
            'start_date' => Carbon::parse($this->startDate), // Convert to proper datetime
            'end_date' => Carbon::parse($this->endDate), // Convert to proper datetime
        ]);
    
        // Process the CSV file and insert questions into quizzes
        if (($handle = fopen($this->csvFile->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle); // Skip the header row if present
            while ($row = fgetcsv($handle)) {
                Quiz::create([
                    'quiz_id' => $quizList->quiz_id, // Link to the newly created quiz_list entry
                    'user_id' => auth()->id(),
                    'question' => $row[0] ?? '', // Question text
                    'option' => json_encode([
                        $row[1] ?? null, // Option 1
                        $row[2] ?? null, // Option 2
                        $row[3] ?? null, // Option 3
                        $row[4] ?? null, // Option 4
                    ]),
                    'correct_answer' => $row[5] ?? '', // Correct answer
                ]);
            }
            fclose($handle);
        }
    
        toastr()->success('Quiz ' . $this->quizName . ' created successfully.');
        $this->reset(['csvFile', 'quizName', 'quizDuration', 'quizSet', 'startDate', 'endDate']);
        $this->showModal = false;
        
        session()->flash('success', 'Quiz uploaded successfully!');
    }

    public function render()
    {
        // Fetch all quizzes created by the current user
        $quizzes = QuizList::where('user_id', auth()->id())
            ->with('quizzes') // Load related questions
            ->get();

        return view('livewire.quiz-upload', [
            'quizzes' => $quizzes,
        ]);
    }
}
