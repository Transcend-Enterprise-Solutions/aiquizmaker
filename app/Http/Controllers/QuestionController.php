<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Update the question data via AJAX.
     */
    public function update(Request $request, Question $question)
    {
        // Validate the incoming data
        $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2|max:4', // Ensure 2-4 options are provided
            'correct_answer' => 'required|string|in:' . implode(',', $request->input('options', [])),
        ]);

        // Update the question
        $question->update([
            'question' => $request->input('question'),
            'option' => json_encode($request->input('options')), // Save options as JSON
            'correct_answer' => $request->input('correct_answer'),
        ]);

        // Respond with success
        return response()->json([
            'message' => 'Question updated successfully!',
            'question' => $question,
        ]);
    }
}
