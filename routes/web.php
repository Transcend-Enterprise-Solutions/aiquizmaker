<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\User;
use App\Http\Controllers\QuizController;
use Inertia\Inertia; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SubjectController;

// Question Form Route
Route::get('/questions', function () {
    return view('questions.form');
})->name('questions.form');

// Question Generation Route
Route::post('/questions/generate', [QuestionController::class, 'generateQuestions'])->name('questions.generate');

// Save Questions Route
Route::post('/save-questions', function (\Illuminate\Http\Request $request) {
    $questions = $request->input('questions');

    // Save questions logic here (e.g., database or file storage)
    foreach ($questions as $index => $questionData) {
        // Example of saving question
        // Question::create($questionData);
    }

    return redirect()->route('questions.form')->with('success', 'Questions saved successfully!');
})->name('save.questions');



Route::post('/save-questions', function (\Illuminate\Http\Request $request) {
    $questions = $request->input('questions');

    // Save or update questions logic
    foreach ($questions as $questionData) {
        // Example: Save question and options to a database
        // Question::updateOrCreate(['id' => $questionData['id']], $questionData);
    }

    return redirect()->route('questions.form')->with('success', 'Questions saved successfully!');
})->name('save.questions');







// Logout Route

Route::post('/logout', function () {
    auth()->logout();
    return redirect('/')->with('message', 'Logged out successfully.');
})->name('logout');

// Dashboard Redirect
Route::get('/dashboard', function () {
    if (auth()->user()->role === 'student') {
        return redirect()->route('student.dashboard');
    } elseif (auth()->user()->role === 'instructor') {
        return redirect()->route('instructor.dashboard');
    } else {
        abort(403, 'Unauthorized');
    }
})->middleware('auth')->name('dashboard');

// Student Dashboard
Route::get('/student/dashboard', [StudentController::class, 'index'])
    ->name('student.dashboard')
    ->middleware('auth');


Route::get('/student/subjects', [StudentController::class, 'enrolledSubjects'])
    ->name('student.enrolledSubjects')
    ->middleware('auth');

Route::get('/student/quizzes', [StudentController::class, 'quizzes'])
    ->name('student.quizzes')
    ->middleware('auth');

Route::get('/student/quiz/{quizId}', [StudentController::class, 'takeQuiz'])
    ->name('student.takeQuiz')
    ->middleware('auth');

Route::post('/student/quiz/{quizId}/submit', [StudentController::class, 'submitQuiz'])
    ->name('student.submitQuiz')
    ->middleware('auth');

Route::get('/student/quiz/{quizId}', [StudentController::class, 'takeQuiz'])->name('student.takeQuiz');

Route::get('/student/quiz/{quizId}/review', [StudentController::class, 'reviewQuiz'])->name('student.reviewQuiz');


Route::get('/student/results', [StudentController::class, 'showResults'])->name('student.results');






// Profile Routes
// Instructor Dashboard
Route::get('/instructor-dashboard', [InstructorController::class, 'index'])
    ->name('instructor.dashboard')
    ->middleware('auth');


// Admin Dashboard
Route::get('/admin-dashboard', [AdminController::class, 'index'])
    ->name('admin.dashboard')
    ->middleware('auth');

// Create a Subject
Route::get('/admin/create-subject', [AdminController::class, 'showCreateSubjectForm'])
    ->name('admin.createSubject')
    ->middleware('auth');
    
Route::post('/admin/create-subject', [AdminController::class, 'createSubject'])
    ->name('admin.storeSubject')
    ->middleware('auth');

// Display All Subjects
Route::get('/admin/subjects', [AdminController::class, 'manageSubjects'])
    ->name('admin.subjects')
    ->middleware('auth');

// Assign Subjects to Students
Route::get('/admin/assign-subject', [AdminController::class, 'assignSubjectForm'])
    ->name('admin.assignSubject')
    ->middleware('auth');
Route::post('/admin/assign-subject', [AdminController::class, 'assignSubjectToStudent'])
    ->name('admin.storeAssignSubject')
    ->middleware('auth');



// Route for the Instructor Dashboard (Welcome page)
Route::get('/instructor/dashboard', [InstructorController::class, 'index'])
    ->name('instructor.welcome')
    ->middleware('auth');

// Route for Instructor Quiz page, named 'instructor.quiz'
Route::get('/instructor/quiz', [InstructorController::class, 'quiz'])
    ->name('instructor.quiz')
    ->middleware('auth');


// Route for Instructor Uplaod CSV, named 'instructor.upload'
Route::get('/instructor/upload', [InstructorController::class, 'upload'])
    ->name('instructor.upload')
    ->middleware('auth');


    // Route for Instructor Uplaod CSV, named 'instructor.upload'
Route::get('/instructor/enroll', [InstructorController::class, 'enroll'])
->name('instructor.enroll')
->middleware('auth');


// Fetch students
Route::get('/get-students', [StudentController::class, 'getStudents'])->name('get-students');

// Quiz Routes
Route::get('/quiz/{id}', [QuizController::class, 'show'])->name('quiz.view');

// Question Routes
Route::put('/questions/{id}', [QuizController::class, 'update'])->name('questions.update'); // Update question
Route::delete('/questions/{id}', [QuizController::class, 'destroy'])->name('questions.destroy'); // Delete question


// Welcome Page
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Debug Route for Environment Variables
Route::get('/debug-env', function () {
    return response()->json(['api_key' => env('OPENAI_API_KEY')]);
});

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// OpenAI API Testing Route
Route::get('/test-openai', function () {
    $apiKey = env('OPENAI_API_KEY'); // Use API key from .env

    if (!$apiKey) {
        return response()->json(['error' => 'OpenAI API key is not set.'], 500);
    }

    try {
        $client = \OpenAI::client($apiKey);

        $response = $client->chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'user', 'content' => 'Generate 3 easy multiple choice questions about science.'],
            ],
            'max_tokens' => 500,
        ]);

        return response()->json($response['choices'][0]['message']['content']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});





// Fallback Route for 404 Errors
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
