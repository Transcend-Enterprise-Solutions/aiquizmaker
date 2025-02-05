<?php

namespace App\Http\Controllers;

use App\Models\QuizList;
use App\Models\Question;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a quiz and its related questions.
     */
    public function show($id)
    {
        $quiz = QuizList::with('quizzes')->findOrFail($id);

        // Ensure each question's option is decoded to an array
        foreach ($quiz->questions as $question) {
            $question->option = json_decode($question->option, true);
        }
    
        return view('quiz.view', compact('quiz'));
    }

    /**
     * Update a specific question.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'question' => 'required|string|max:1000', // Increased max length
                'options' => 'required|array|min:2|max:4',
                'correct_answer' => [
                    'required',
                    'string',
                    function ($attribute, $value, $fail) use ($request) {
                        // Check if the correct_answer exists in the options array
                        if (!in_array($value, $request->input('options'))) {
                            $fail('The selected correct answer is invalid.');
                        }
                    },
                ],
            ]);
    
            // Find the question by ID
            $question = Question::findOrFail($id);
    
            // Update the question
            $question->update([
                'question' => $request->input('question'),
                'option' => json_encode($request->input('options')), // Ensure options are stored as JSON
                'correct_answer' => $request->input('correct_answer'),
            ]);
    
            // Flash success message
            toastr()->success('Question updated successfully!');
            return back();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            toastr()->error('Failed to update question. Please try again.');
            return back()->withInput();
        }
    }
    

    /**
     * Delete a specific question.
     */
    public function destroy($id)
    {
        try {
            // Find the question by ID
            $question = Question::findOrFail($id);

            // Delete the question
            $question->delete();

            // Flash success message using Toastr
            toastr()->success('Question deleted successfully!');
            return back();
        } catch (\Exception $e) {
            // Log the error and flash an error message using Toastr
            \Log::error($e->getMessage());
            toastr()->error('Failed to delete question. Please try again.');
            return back();
        }
    }
}
