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
use App\Models\Question;


class StudentController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();
    
        // Total courses enrolled
        $totalCourses = Auth::user()->enrolledSubjects()->count();
    
        // Total quizzes taken
        $quizzesTaken = StudentQuizResult::where('student_id', $studentId)->count();
    
        // Average score
        $averageScore = StudentQuizResult::where('student_id', $studentId)->avg('percentage') ?? 0;
    
        // Pass percentage
        $passPercentage = StudentQuizResult::where('student_id', $studentId)
            ->where('status', 'Pass')
            ->count();
    
        // Get upcoming quizzes
        $upcomingQuizzes = Auth::user()->enrolledSubjects()
            ->with(['quizLists' => function ($query) {
                $query->where('start_date', '>', now())->orderBy('start_date');
            }])
            ->get();
    
        return view('dashboards.studentfolder.welcome', compact(
            'totalCourses', 'quizzesTaken', 'averageScore', 'passPercentage', 'upcomingQuizzes'
        ));
    }
    
    public function upcomingQuizzes()
    {
        $now = Carbon::now();
        $upcomingQuizzes = QuizList::whereHas('students', function ($query) {
            $query->where('student_id', auth()->id());
        })->where('start_date', '>', $now)
          ->orderBy('start_date', 'asc')
          ->get();
    
        return view('dashboards.studentfolder.upcoming-quizzes', compact('upcomingQuizzes'));
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
        // Ensure the user is a student
        if (auth()->user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }
    
        // Fetch the enrolled subjects with related data
        $subjects = Auth::user()
            ->enrolledSubjects()
            ->with(['instructors', 'quizzes'])
            ->get();
    
        // Pass the subjects to the view
        return view('dashboards.studentfolder.subjects', compact('subjects'));
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
    
    
    
    public function showResults(Request $request)
    {
        $sortField = $request->query('sort', 'created_at'); // Default sort by date
        $sortDirection = $request->query('direction', 'desc'); // Default descending
        $filterStatus = $request->query('status'); // Optional filter
    
        // Fetch results with sorting and filtering
        $query = StudentQuizResult::where('student_id', auth()->id())->with('quiz');
    
        if ($filterStatus) {
            $query->where('status', $filterStatus);
        }
    
        $results = $query->orderBy($sortField, $sortDirection)->get();
    
        return view('dashboards.studentfolder.results', compact('results', 'sortField', 'sortDirection', 'filterStatus'));
    }
    
    public function subjectProgress()
    {
        $subjects = Auth::user()->enrolledSubjects()->with(['quizzes', 'quizzes.results'])->get();
    
        foreach ($subjects as $subject) {
            $totalQuizzes = $subject->quizzes->count();
            $passedQuizzes = $subject->quizzes->where('results.status', 'Pass')->count();
            $subject->progress = $totalQuizzes > 0 ? ($passedQuizzes / $totalQuizzes) * 100 : 0;
        }
    
        return view('dashboards.studentfolder.subject-progress', compact('subjects'));
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
