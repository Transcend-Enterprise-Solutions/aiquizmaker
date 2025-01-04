<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class QuestionManager extends Component
{
    public $topic = '';
    public $difficulty = 'easy';
    public $numberOfQuestions = 5;
    public $questionType = 'multiple_choice';
    public $questions = [];
    public $editing = null; // Tracks the index of the question being edited
    public $chatgptResponse = ''; 

    // Pagination properties
    public $page = 1; // Current page
    public $perPage = 5; // Items per page

    // Validation rules
    protected $rules = [
        'topic' => 'required|string|max:255',
        'difficulty' => 'required|in:easy,medium,hard',
        'numberOfQuestions' => 'required|integer|min:1|max:50',
        'questionType' => 'required|in:multiple_choice,true_false',
    ];

    public function editQuestion($pageIndex)
    {
        // Calculate the global index
        $globalIndex = ($this->page - 1) * $this->perPage + $pageIndex;
        
        // Now use $globalIndex to edit the correct question
        $this->editing = $globalIndex;
    }
    

    // Save changes to a question
    public function saveQuestion($index)
    {
        $rules = [
            "questions.$index.question" => 'required|string',
        ];
    
        if ($this->questionType === 'multiple_choice') {
            $rules["questions.$index.options"] = 'required|array|size:4'; // Exactly 4 options
            $rules["questions.$index.options.*"] = 'required|string|max:255';
            $rules["questions.$index.answer"] = 'required|integer|between:0,3'; // Index of the correct answer
        } elseif ($this->questionType === 'true_false') {
            $rules["questions.$index.answer"] = 'required|integer|between:0,1'; // Only True (0) or False (1)
        }
    
        $this->validate($rules);
    
        $this->editing = null;
        session()->flash('success', 'Question updated successfully!');
    }
    

    // Cancel editing mode
    public function cancelEdit()
    {
        $this->editing = null;
    }

    // Generate questions using OpenAI API
    public function generateQuestions()
    {
        $this->validate();
    
        // Build the prompt
        $prompt = $this->buildPrompt();
    
        // Log the generated prompt for debugging
        \Log::info('Generated Prompt', ['prompt' => $prompt]);
    
        // Send the prompt to the API
        $response = $this->fetchQuestionsFromAPI($prompt);
    
        if (!$response) {
            session()->flash('error', 'Failed to generate questions. Please try again.');
            return;
        }
    
        // Parse the response based on the question type
        $this->questions = $this->parseQuestionsByType($response);
    
        session()->flash('success', 'Questions generated successfully!');
    }
    

    // Centralized parsing function
    private function parseQuestionsByType($responseText)
    {
        if ($this->questionType === 'multiple_choice') {
            return $this->parseMultipleChoiceQuestions($responseText);
        }
        if ($this->questionType === 'true_false') {
            return $this->parseTrueFalseQuestions($responseText);
        }

        return [];
    }

    // Parse multiple-choice questions
    private function parseMultipleChoiceQuestions($responseText)
    {
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);

            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    $questions[] = $currentQuestion;
                }
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => [],
                    'answer' => null,
                ];
            } elseif (preg_match('/^[A-D]\)\s*(.+)/', $line, $matches)) {
                $currentQuestion['options'][] = $matches[1];
            } elseif (stripos($line, 'Answer:') === 0) {
                $answerText = trim(substr($line, 7));
                $currentQuestion['answer'] = array_search($answerText, $currentQuestion['options']);
            }
        }

        if ($currentQuestion) {
            $questions[] = $currentQuestion;
        }

        return $questions;
    }

    // Parse true/false questions
    private function parseTrueFalseQuestions($responseText)
    {
        \Log::info('Parsing True/False Questions', ['responseText' => $responseText]);
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);

            // Match the question (e.g., "1. Is the sky blue?")
            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    $questions[] = $currentQuestion;
                }
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => ['True', 'False'],
                    'answer' => null,
                ];
            }
            // Match the answer (e.g., "Answer: True" or "Answer: False")
            elseif (preg_match('/^Answer:\s*(True|False)/i', $line, $matches)) {
                $currentQuestion['answer'] = strtolower($matches[1]) === 'true' ? 0 : 1;
            }
        }

        if ($currentQuestion) {
            $questions[] = $currentQuestion;
        }

        return $questions;
    }

        // Build API prompt
        // Build API prompt
    // Build API prompt for True/False questions
    private function buildPrompt()
    {
        // Check if the question type is multiple-choice or true/false
        $questionTypeInstruction = $this->questionType === 'multiple_choice' 
            ? "multiple-choice questions" 
            : "true/false questions";  // For True/False questions

        // Base instruction for creating questions
        $baseInstruction = "Create {$this->numberOfQuestions} {$questionTypeInstruction} about '{$this->topic}' with difficulty level {$this->difficulty}.";

        // Guidelines for structuring the questions based on the type
        $structureGuideline = $this->questionType === 'multiple_choice' 
            ? "Each question must have:\n1. A question text.\n2. Exactly 4 options labeled A), B), C), and D).\n3. Indicate the correct answer as 'Answer: OptionLabel'."
            : "Each question must have:\n1. A question text.\n2. Two options: True and False.\n3. Indicate the correct answer explicitly as 'Answer: True' or 'Answer: False'.";

        // Combine the instructions into one prompt
        return "{$baseInstruction}\n\n{$structureGuideline}\n\nEnsure the response is clear and follows the required format.";
    }



    private function fetchQuestionsFromAPI($prompt)
    {
        $apiKey = env('OPENAI_API_KEY');
        
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 2000,
            ]);
    
            // Log the raw response for debugging
            \Log::info('API Response', ['response' => $response->json()]);
            
            // Check the status of the response
            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? null;
                return $content;
            } else {
                $error = $response->json();
                \Log::error('API Error', ['error' => $error]);
                session()->flash('error', 'API request failed. Please check your API key or try again later.');
                return null;
            }
        } catch (\Exception $e) {
            $this->chatgptResponse = 'Error: ' . $e->getMessage();
            \Log::error('API Error', ['exception' => $e->getMessage()]);
            session()->flash('error', 'API request failed. Please try again later.');
            return null;
        }
    }
    
    

    // for api valid8tion
    private function validateResponseFormat($responseText)
    {
        // for multiple choice
        $multipleChoicePattern = '/^\d+\.\s.+\n[A-D]\)\s.+\n[A-D]\)\s.+\n[A-D]\)\s.+\n[A-D]\)\s.+\nAnswer:\s[A-D]\)/m';
        
        // di gumagana masyado
        $trueFalsePattern = '/^\d+\.\s.+\nAnswer:\s(True|False)/mi';

        // if match respone = proceed to nest step
        return preg_match($multipleChoicePattern, $responseText) || preg_match($trueFalsePattern, $responseText);
    }

    // api error_handling
    private function handleApiError($message)
    {
        $this->chatgptResponse = $message;
        \Log::error('OpenAI API Error', ['message' => $message]);
        session()->flash('error', $message);
    }

    // Pagination helpers
    public function getTotalPages()
    {
        return ceil(count($this->questions) / $this->perPage);
    }

    public function getPaginatedQuestionsProperty()
    {
        $offset = ($this->page - 1) * $this->perPage;
        return array_slice($this->questions, $offset, $this->perPage);
    }

    public function nextPage()
    {
        if ($this->page < $this->getTotalPages()) {
            $this->page++;
        }
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function goToPage($pageNumber)
    {
        if ($pageNumber >= 1 && $pageNumber <= $this->getTotalPages()) {
            $this->page = $pageNumber;
        }
    }

    public function deleteQuestion($index)
    {
        if (isset($this->questions[$index])) {
            // Remove the question at the given index
            array_splice($this->questions, $index, 1);
    
            // Optional: Reset pagination if necessary
            if ($this->page > $this->getTotalPages()) {
                $this->page = $this->getTotalPages();
            }
    
            session()->flash('success', 'Question deleted successfully!');
        } else {
            session()->flash('error', 'Unable to delete the question. Index not found.');
        }
    }

    // Render Livewire component
    public function render()
    {
        return view('livewire.question-manager');
    }
}
