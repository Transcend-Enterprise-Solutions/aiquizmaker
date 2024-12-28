<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class QuestionManager extends Component
{
    public $topic = '';
    public $difficulty = 'easy';
    public $numberOfQuestions = 5;
    public $questionType = 'multiple_choice'; // 'multiple_choice' or 'true_false'
    public $questions = [];
    public $editingAnswerIndex = null; // Tracks which question's answer is being edited

    protected $rules = [
        'topic' => 'required|string|max:255',
        'difficulty' => 'required|in:easy,medium,hard',
        'numberOfQuestions' => 'required|integer|min:1|max:50',
        'questionType' => 'required|in:multiple_choice,true_false',
    ];

    public function setAnswer($index, $newAnswer)
    {
        if (isset($this->questions[$index])) {
            $this->questions[$index]['answer'] = $newAnswer;
            session()->flash('success', "Answer updated for Question " . ($index + 1) . "!");
        }
    }

    public function startEditingAnswer($index)
    {
        $this->editingAnswerIndex = $index;
    }

    public function stopEditingAnswer()
    {
        $this->editingAnswerIndex = null;
    }

    public function generateQuestions()
    {
        $this->validate();

        $apiKey = env('OPENAI_API_KEY');
        $isMultipleChoice = $this->questionType === 'multiple_choice';

        $prompt = $isMultipleChoice
            ? "Generate {$this->numberOfQuestions} multiple-choice questions about '{$this->topic}'. Each question should have 4 options, and indicate the correct option in the format 'Answer: optionText'."
            : "Generate {$this->numberOfQuestions} true/false questions about '{$this->topic}'. Indicate the correct answer in the format 'Answer: True' or 'Answer: False'.";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer $apiKey",
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 1000,
            ]);

            $data = $response->json();
            if (isset($data['choices'][0]['message']['content'])) {
                $content = $data['choices'][0]['message']['content'];
                $this->questions = $isMultipleChoice
                    ? $this->parseQuestions($content)
                    : $this->parseTrueFalseQuestions($content);

                session()->flash('success', 'Questions generated successfully!');
            } else {
                throw new \Exception('Unexpected API response structure.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to generate questions: ' . $e->getMessage());
        }
    }

    private function parseQuestions($responseText)
    {
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line)) {
                continue; // Skip empty lines
            }

            // Match question line
            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    $questions[] = $currentQuestion;
                }
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => [],
                    'answer' => null,
                ];
            }
            // Match option lines (A), (B), etc.
            elseif (preg_match('/^[A-D]\)\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    $currentQuestion['options'][] = $matches[1];
                }
            }
            // Match answer line
            elseif (stripos($line, 'Answer:') === 0) {
                if ($currentQuestion) {
                    $currentQuestion['answer'] = trim(substr($line, 7)); // Extract the correct answer
                }
            }
        }

        if ($currentQuestion) {
            $questions[] = $currentQuestion;
        }

        return $questions;
    }

    private function parseTrueFalseQuestions($responseText)
    {
        $lines = explode("\n", $responseText);
        $questions = [];
        $currentQuestion = null;

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line)) {
                continue; // Skip empty lines
            }

            // Match question line
            if (preg_match('/^\d+\.\s*(.+)/', $line, $matches)) {
                if ($currentQuestion) {
                    $questions[] = $currentQuestion;
                }
                $currentQuestion = [
                    'question' => $matches[1],
                    'options' => ['True', 'False'], // True/False options
                    'answer' => null,
                ];
            }
            // Match answer line
            elseif (stripos($line, 'Answer:') === 0) {
                if ($currentQuestion) {
                    $currentQuestion['answer'] = trim(substr($line, 7)); // Extract the correct answer
                }
            }
        }

        if ($currentQuestion) {
            $questions[] = $currentQuestion;
        }

        return $questions;
    }

    public function render()
    {
        return view('livewire.question-manager');
    }
}
