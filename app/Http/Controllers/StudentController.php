<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Subject;
use App\Models\QuizList;
use App\Models\User;
use Carbon\Carbon;
use App\Models\StudentQuizAttempt;
use App\Models\StudentQuizResult;


class StudentController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        return view('dashboards.studentfolder.welcome');
    }

    public function getStudents()
    {
        // Fetch only students with the role 'student'
        $students = User::select('name', 'role')
            ->where('role', 'student')
            ->get();

        // Return the students as JSON
        return response()->json($students);
    }

    /**
     * Display the enrolled subjects for the logged-in student.
     */
    public function enrolledSubjects()
    {


        if (auth()->user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }


        $enrolledSubjects = Auth::user()->enrolledSubjects; // Use the relationship in the User model
        return view('dashboards.studentfolder.subjects', compact('enrolledSubjects'));
    }

    public function quizzes()
    {
        $now = Carbon::now('Asia/Manila'); // Ensure the correct timezone
        $subjects = Auth::user()->enrolledSubjects()->with(['quizLists' => function ($query) use ($now) {
            $query->where('start_date', '<=', $now)
                  ->where('end_date', '>=', $now);
        }])->get();
    
        return view('dashboards.studentfolder.quizzes', compact('subjects'));
    }
    
    
    public function takeQuiz($quizId)
    {
        
        $quiz = QuizList::with('questions')->findOrFail($quizId);

        $quiz->questions = $quiz->questions->shuffle(); // Shuffle the questions
        // Ensure the quiz is within the valid time range
        $now = now();
        if ($now->lt($quiz->start_date) || $now->gt($quiz->end_date)) {
            return redirect()->route('student.quizzes')->with('error', 'This quiz is not available at the moment.');
        }
    
        return view('dashboards.studentfolder.take-quiz', compact('quiz'));



    }
    
    public function submitQuiz(Request $request, $quizId)
    {
        $quiz = QuizList::with('questions')->findOrFail($quizId);
        $studentId = Auth::id();
        $score = 0;
    
        foreach ($quiz->questions as $question) {
            // Get the student's selected answer index
            $studentAnswerIndex = $request->input("answers.{$question->id}");
            
            // Decode the options JSON
            $options = json_decode($question->option, true);
            
            // Get the actual text of the selected answer
            $studentAnswer = $options[$studentAnswerIndex] ?? null;
    
            // Check if the answer is correct
            $isCorrect = $studentAnswer === $question->correct_answer;
    
            // Save individual attempts
            StudentQuizAttempt::create([
                'student_id' => $studentId,
                'quiz_id' => $quizId,
                'question_id' => $question->id,
                'answer' => $studentAnswer, // Save the actual answer text
                'is_correct' => $isCorrect,
            ]);
    
            if ($isCorrect) {
                $score++;
            }
        }
    
        // Save overall quiz result
        $totalQuestions = $quiz->questions->count();
        $percentage = ($score / $totalQuestions) * 100;
        $status = $percentage >= 50 ? 'Pass' : 'Fail';
    
        StudentQuizResult::create([
            'student_id' => $studentId,
            'quiz_id' => $quizId,
            'score' => $score,
            'total_questions' => $totalQuestions,
            'percentage' => $percentage,
            'status' => $status,
        ]);
    
        return redirect()->route('student.results')->with('success', 'Quiz submitted successfully!');
    }
    
    
    
    public function showResults()
    {
        $results = StudentQuizResult::where('student_id', auth()->id())->with('quiz')->get();

        // Fetch the student's quiz attempts (questions and answers)
        foreach ($results as $result) {
            $result->attempts = StudentQuizAttempt::where('quiz_id', $result->quiz_id)
                                                ->where('student_id', auth()->id())
                                                ->get();
        }

        return view('dashboards.studentfolder.results', compact('results'));
    }
    public function reviewQuiz($quizId)
    {
        $quiz = QuizList::with('questions')->findOrFail($quizId);
    
        // Get the student's quiz attempts
        $attempts = StudentQuizAttempt::where('quiz_id', $quizId)
                                      ->where('student_id', auth()->id())
                                      ->get();
    
        return view('dashboards.studentfolder.review-quiz', compact('quiz', 'attempts'));
    }
    
    
}
