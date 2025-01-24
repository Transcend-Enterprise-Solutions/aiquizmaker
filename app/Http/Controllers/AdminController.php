<?php

namespace App\Http\Controllers;
use App\Models\Subject; // Import Subject model
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized');
        }

        return view('dashboards.adminfolder.welcome');
    }

    public function showCreateSubjectForm()
    {
        return view('dashboards.adminfolder.create_subject');
    }

    public function assignSubjectForm()
    {
        $students = User::where('role', 'student')->get();
        $subjects = Subject::all();
    
        return view('dashboards.adminfolder.assign_subject', compact('students', 'subjects'));
    }
    
    public function assignSubjectToStudent(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);
    
        $student = User::find($request->student_id);
        $student->subjects()->attach($request->subject_id);
    
        return redirect()->route('admin.assignSubject')->with('success', 'Subject assigned to student successfully!');
    }
    

    public function manageSubjects()
    {
        // Fetch all subjects
        $subjects = Subject::all();

        // Return the view with the subjects data
        return view('dashboards.adminfolder.manage_subjects', compact('subjects'));
    }
}
