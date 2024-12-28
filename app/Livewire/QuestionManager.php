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

    // Pagination properties
    public $page = 1; // Current page
    public $perPage = 10; // Items per page

    // Validation rules
    protected $rules = [
        'topic' => 'required|string|max:255',
        'difficulty' => 'required|in:easy,medium,hard',
        'numberOfQuestions' => 'required|integer|min:1|max:50',
        'questionType' => 'required|in:multiple_choice,true_false',
    ];

    // Edit a specific question
    public function editQuestion($index)
    {
        $this->editing = $index;
    }

    // Save changes to a question
    public function saveQuestion($index)
    {
        $this->validate([
            "questions.$index.question" => 'required|string',
            "questions.$index.options.*" => 'required|string',
            "questions.$index.answer" => 'required|string',
        ]);

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

    // Build API prompt
    private function buildPrompt()
    {
        return $this->questionType === 'multiple_choice'
            ? "Generate {$this->numberOfQuestions} multiple-choice questions about '{$this->topic}'. Each question should have 4 options and indicate the correct option in the format 'Answer: optionText'."
            : "Generate {$this->numberOfQuestions} true/false questions about '{$this->topic}'. Indicate the correct answer in the format 'Answer: True' or 'Answer: False'.";
    }

    // Fetch questions from OpenAI API
    private function fetchQuestionsFromAPI($prompt)
    {
        $apiKey = env('OPENAI_API_KEY');

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'max_tokens' => 3000,
            ]);

            $data = $response->json();

            return $data['choices'][0]['message']['content'] ?? null;
        } catch (\Exception $e) {
            session()->flash('error', 'API request failed. Please check your API key or try again later.');
            return null;
        }
    }

    // Parse multiple-choice questions
    private function parseQuestions($responseText)
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
                $currentQuestion['answer'] = trim(substr($line, 7));
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
                    'options' => ['True', 'False'],
                    'answer' => null,
                ];
            } elseif (stripos($line, 'Answer:') === 0) {
                $currentQuestion['answer'] = trim(substr($line, 7));
            }
        }

        if ($currentQuestion) {
            $questions[] = $currentQuestion;
        }

        return $questions;
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

    // Render Livewire component
    public function render()
    {
        return view('livewire.question-manager');
    }
}
