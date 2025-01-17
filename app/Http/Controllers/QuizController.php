<?php

namespace App\Http\Controllers;

use App\Models\QuizList;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function show($id)
    {
        // Fetch the quiz and related questions
        $quiz = QuizList::with('quizzes')->findOrFail($id);

        // Pass the quiz data to the view
        return view('quiz.view', compact('quiz'));
    }
}
