<?php

namespace App\Http\Controllers;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class InstructorController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }

        return view('dashboards.instructorfolder.welcome');
    }

    public function welcome()
    {
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }
        return view('dashboards.instructorfolder.welcome');
    }
    public function quiz()
    {
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }
        return view('dashboards.instructorfolder.quiz');
    }
    public function upload()
    {
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }
        return view('dashboards.instructorfolder.upload');
    }

    public function enroll()
    {
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }
        return view('dashboards.instructorfolder.enroll');
    }
    
    public function subject()
    {
        // Ensure only instructors can access this page
        if (auth()->user()->role !== 'instructor') {
            abort(403, 'Unauthorized');
        }
    
        // Fetch subjects assigned to the logged-in instructor
        $subjects = Auth::user()
            ->instructorSubjects() // Assuming this is the relationship to fetch subjects
            ->with(['quizzes', 'students', 'creator']) // Eager load related data
            ->get();
    
        // Pass the filtered subjects to the view
        return view('dashboards.instructorfolder.subjects', compact('subjects'));
    }
}
