<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class StudentController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        return view('dashboards.studentfolder.student');
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
    
}
