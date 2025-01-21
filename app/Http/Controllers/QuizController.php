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

    /**
     * Update a specific question.
     */
    public function update(Request $request, $id)
    {
        try {
            // Validate the request
            $request->validate([
                'question' => 'required|string|max:255',
                'options' => 'required|array|min:2|max:4',
                'correct_answer' => 'required|string|in:' . implode(',', $request->input('options', [])),
            ]);

            // Find the question by ID
            $question = Question::findOrFail($id);

            // Update the question
            $question->update([
                'question' => $request->input('question'),
                'option' => json_encode($request->input('options')), // Store options as JSON
                'correct_answer' => $request->input('correct_answer'),
            ]);

            // Return success response
            return response()->json(['message' => 'Question updated successfully!']);
        } catch (\Exception $e) {
            // Log the error and return failure response
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to update question.'], 500);
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

            // Return success response
            return response()->json(['message' => 'Question deleted successfully!']);
        } catch (\Exception $e) {
            // Log the error and return failure response
            \Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete question.'], 500);
        }
    }
    public function show($id)
    {
        // Fetch the quiz along with its questions
        $quiz = QuizList::with('quizzes')->findOrFail($id);

        // Return the view with the quiz data
        return view('quiz.view', compact('quiz'));
    }
}
