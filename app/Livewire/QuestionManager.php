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
        toastr()->success('Question updated successfully!');
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
    
        // Fetch response from API
        $response = $this->fetchQuestionsFromAPI($prompt);
    
        if (!$response) {
            toastr()->error('Failed to generate questions. Please try again.');
            return;
        }
    
        // Parse the response based on the question type
        $this->questions = $this->parseQuestionsByType($response);
    
        toastr()->success('Questions generated successfully!');
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

    private function parseMultipleChoiceQuestions($responseText)
    {
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Detect a new question
            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    // Validate and save the current question
                    if (count($currentQuestion['options']) === 4 && $currentQuestion['answer'] !== null) {
                        $questions[] = $currentQuestion;
                    }
                }
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => [],
                    'answer' => null,
                ];
            }
            // Detect options (A, B, C, D)
            elseif (preg_match('/^[A-D]\)\s*(.+)/', $line, $matches)) {
                $currentQuestion['options'][] = $matches[1];
            }
            // Detect the answer
            elseif (preg_match('/^Answer:\s*([A-D])\)/i', $line, $matches)) {
                $answerIndex = ord(strtoupper($matches[1])) - 65;
                if (isset($currentQuestion['options'][$answerIndex])) {
                    $currentQuestion['answer'] = $answerIndex;
                }
            }
        }
    
        // Add the last question
        if ($currentQuestion && count($currentQuestion['options']) === 4 && $currentQuestion['answer'] !== null) {
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
    private function buildPrompt()
    {
        // Determine the question type (Multiple-choice or True/False)
        $questionTypeInstruction = $this->questionType === 'multiple_choice' 
            ? "multiple-choice questions" 
            : "true/false questions";
    
        // Base instruction for generating questions
        $baseInstruction = "Generate {$this->numberOfQuestions} {$questionTypeInstruction} on the topic '{$this->topic}' with a '{$this->difficulty}' difficulty level.";
    
        // Guidelines for structuring questions based on the type
        $structureGuideline = $this->questionType === 'multiple_choice'
            ? "1. Each question must include a clear and concise question text.\n"
              . "2. Provide exactly 4 answer options labeled A), B), C), and D).\n"
              . "3. Clearly indicate the correct answer in this format: 'Answer: OptionLabel'.\n"
              . "4. Ensure all answers are factually accurate and contextually relevant."
            : "1. Each question must include a clear and concise question text.\n"
              . "2. Provide two options: True and False.\n"
              . "3. Clearly indicate the correct answer explicitly in this format: 'Answer: True' or 'Answer: False'.\n"
              . "4. Ensure all answers are factually accurate and contextually relevant.";
    
        // Combine all components into the final prompt
        $completePrompt = "{$baseInstruction}\n\nStructure Guidelines:\n{$structureGuideline}\n\n"
            . "Ensure the response is well-structured, follows the required format, and avoids irrelevant or misleading options.";
    
        return $completePrompt;
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
                'max_tokens' => 4000,
            ]);
    
            // Log the raw response for debugging
            \Log::info('API Response', ['response' => $response->json()]);
            
            // Check the status of the response
            if ($response->successful()) {
                $data = $response->json();
                $content = $data['choices'][0]['message']['content'] ?? null;
                $this->chatgptResponse = $content; // Store the response for debugging
                return $content;
            } else {
                $error = $response->json();
                \Log::error('API Error', ['error' => $error]);
                toastr()->error('API request failed. Please try again later.');
                return null;
            }
        } catch (\Exception $e) {
            $this->chatgptResponse = 'Error: ' . $e->getMessage();
            \Log::error('API Error', ['exception' => $e->getMessage()]);
            toastr()->error('API request failed. Please try again later.');
            return null;
        }
    }

    // for api validation
    private function validateResponseFormat($responseText)
    {
        $multipleChoicePattern = '/^\d+\.\s.+\nA\)\s.+\nB\)\s.+\nC\)\s.+\nD\)\s.+\nAnswer:\s[A-D]$/m';

        $trueFalsePattern = '/^\d+\.\s.+\nAnswer:\s(True|False)/mi';
    
        return preg_match($multipleChoicePattern, $responseText) || preg_match($trueFalsePattern, $responseText);
    }
    
    // api error_handling
    private function handleApiError($message)
    {
        $this->chatgptResponse = $message;
        \Log::error('OpenAI API Error', ['message' => $message]);
        toastr()->error('Failed to generate questions. Please try again.');
    }

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
        if ($this->page < $this->getTotalPages()) $this->page++;
    }

    public function previousPage()
    {
        if ($this->page > 1) $this->page--;
    }

    public function goToPage($pageNumber)
    {
        if ($pageNumber >= 1 && $pageNumber <= $this->getTotalPages()) {
            $this->page = $pageNumber;
        }
    }

    public function deleteQuestion($globalIndex)
    {
        if (isset($this->questions[$globalIndex])) {
            array_splice($this->questions, $globalIndex, 1);
            if ($this->page > $this->getTotalPages()) {
                $this->page = $this->getTotalPages();
            }

            toastr()->success('Question deleted successfully!');
        } else {
            toastr()->error('Failed to delete the question.');
        }
    }

    

    public function downloadCsv()
    {
        $fileName = 'questions.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];
    
        $callback = function () {
            $handle = fopen('php://output', 'w');
    
            // Write the CSV header
            fputcsv($handle, ['Question', 'Option A', 'Option B', 'Option C', 'Option D', 'Correct Answer']);
    
            // Write the question data
            foreach ($this->questions as $question) {
                if ($this->questionType === 'multiple_choice') {
                    // Multiple Choice Question
                    $row = [
                        $question['question'], // Question
                        $question['options'][0] ?? '', // Option A
                        $question['options'][1] ?? '', // Option B
                        $question['options'][2] ?? '', // Option C
                        $question['options'][3] ?? '', // Option D
                        $question['options'][$question['answer']] ?? '', // Correct Answer
                    ];
                } elseif ($this->questionType === 'true_false') {
                    // True/False Question (adapted to include "Option A" and "Option B")
                    $row = [
                        $question['question'], // Question
                        'True', // Option A
                        'False', // Option B
                        '', // Option C
                        '', // Option D
                        $question['options'][$question['answer']] ?? '', // Correct Answer
                    ];
                }
                fputcsv($handle, $row);
            }
    
            fclose($handle);
        };
    
        return response()->stream($callback, 200, $headers);
    }
    
    
    
    
    
    // Render Livewire component
    public function render()
    {
        return view('livewire.question-manager');
    }
}
