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
    public $editing = null;
    public $chatgptResponse = '';

    public $page = 1;
    public $perPage = 5;

    protected $rules = [
        'topic' => 'required|string|max:255',
        'difficulty' => 'required|in:easy,medium,hard',
        'numberOfQuestions' => 'required|integer|min:1|max:50',
        'questionType' => 'required|in:multiple_choice,true_false',
    ];

    public function editQuestion($globalIndex)
    {
        $this->editing = $globalIndex;
    }

    public function saveQuestion($globalIndex)
    {
        $rules = ["questions.$globalIndex.question" => 'required|string'];

        if ($this->questionType === 'multiple_choice') {
            $rules += [
                "questions.$globalIndex.options" => 'required|array|size:4',
                "questions.$globalIndex.options.*" => 'required|string|max:255',
                "questions.$globalIndex.answer" => 'required|integer|between:0,3',
            ];
        } else {
            $rules["questions.$globalIndex.answer"] = 'required|integer|between:0,1';
        }

        $this->editing = null;
        session()->flash('success', 'Question updated successfully!');
    }

    public function cancelEdit()
    {
        $this->editing = null;
    }

    public function generateQuestions()
    {
        $this->validate();

        $prompt = $this->buildPrompt();
        $response = $this->fetchQuestionsFromAPI($prompt);

        if ($response) {
            $this->questions = $this->questionType === 'multiple_choice'
                ? $this->parseQuestions($response)
                : $this->parseTrueFalseQuestions($response);

            session()->flash('success', 'Questions generated successfully!');
        } else {
            session()->flash('error', 'Failed to generate questions. Please try again.');
        }
    }

    private function buildPrompt()
    {
        $typeSpecificInstruction = $this->questionType === 'multiple_choice'
            ? "Each question must have:\n1. A question text.\n2. Exactly 4 answer options labeled A), B), C), and D).\n3. Indicate the correct answer explicitly in the format: 'Answer: OptionLabel'."
            : "Each question must have:\n1. A question text.\n2. Two answer options: True and False.\n3. Indicate the correct answer explicitly in the format: 'Answer: True' or 'Answer: False'.";

        return "Create {$this->numberOfQuestions} {$this->questionType} questions about '{$this->topic}' at {$this->difficulty} level.\n\n$typeSpecificInstruction\n\nEnsure the response is well-structured and adheres to the specified format.";
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
    
            $content = $response->json()['choices'][0]['message']['content'] ?? null;
            $this->chatgptResponse = $content;
    
            \Log::info('OpenAI Response', ['response' => $content]);
    
            if ($content && $this->validateResponseFormat($content)) {
                return $content;
            } else {
                \Log::error('Response Validation Failed', [
                    'response' => $content,
                    'expected_format' => $this->questionType,
                ]);
                session()->flash('error', 'Invalid response format. Please check debugging info.');
                return null;
            }
        } catch (\Exception $e) {
            $this->chatgptResponse = 'Error: ' . $e->getMessage();
            \Log::error('OpenAI API Error', ['exception' => $e->getMessage()]);
            session()->flash('error', 'API request failed. Please check your API key or try again later.');
            return null;
        }
    }
    

    private function validateResponseFormat($responseText)
    {
        $patterns = [
            'multiple_choice' => '/^\\d+\\.\\s.+\\nA\\)\\s.+\\nB\\)\\s.+\\nC\\)\\s.+\\nD\\)\\s.+\\nAnswer:\\s[A-D]\\)?/mi',
            'true_false' => '/^\\d+\\.\\s.+\\nAnswer:\\s(True|False)/mi',
        ];
    
        return preg_match($patterns[$this->questionType], $responseText);
    }
    

    private function parseQuestions($responseText)
    {
        return $this->parseResponse($responseText, true);
    }

    private function parseTrueFalseQuestions($responseText)
    {
        return $this->parseResponse($responseText, false);
    }

    private function parseResponse($responseText, $isMultipleChoice)
    {
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;
    
        foreach ($lines as $line) {
            $line = trim($line);
    
            // Match question text (e.g., "1. What is HTML?")
            if (preg_match('/^\\d+\\.\\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) $questions[] = $currentQuestion;
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => $isMultipleChoice ? [] : ['True', 'False'],
                    'answer' => null,
                ];
            }
            // Match multiple-choice options (e.g., "A) Option Text")
            elseif ($isMultipleChoice && preg_match('/^[A-D]\\)\\s*(.+)/', $line, $matches)) {
                $currentQuestion['options'][] = strip_tags($matches[1]); // Remove any HTML tags
            }
            // Match answer (e.g., "Answer: A" or "Answer: True")
            elseif (preg_match('/^Answer:\\s*([A-D]|True|False)\\)?/i', $line, $matches)) {
                $answerText = trim($matches[1]);
                $currentQuestion['answer'] = $isMultipleChoice
                    ? array_search(strtoupper($answerText), ['A', 'B', 'C', 'D'])
                    : (strtolower($answerText) === 'true' ? 0 : 1);
            }
        }
    
        if ($currentQuestion) $questions[] = $currentQuestion;
    
        return $questions;
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
            session()->flash('success', 'Question deleted successfully!');
        } else {
            session()->flash('error', 'Unable to delete the question.');
        }
    }

    public function render()
    {
        return view('livewire.question-manager', [
            'paginatedQuestions' => $this->getPaginatedQuestionsProperty(),
        ]);
    }
}