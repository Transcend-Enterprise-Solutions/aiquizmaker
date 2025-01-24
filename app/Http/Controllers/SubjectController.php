<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Create a new subject.
     */
    public function createSubject(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create the subject
        Subject::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(), // Admin's ID
        ]);

        return back()->with('success', 'Subject created successfully!');
    }

    /**
     * Assign a subject to an instructor.
     */
    public function assignSubjectToInstructor(Request $request)
    {
        // Validate the input
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Find the instructor and assign the subject
        $instructor = User::find($request->instructor_id);
        $instructor->subjects()->attach($request->subject_id);

        return back()->with('success', 'Subject assigned to instructor successfully!');
    }

    /**
     * Show the form to assign subjects to instructors.
     */
    public function showAssignSubjectForm()
    {
        $instructors = User::where('role', 'instructor')->get();
        $subjects = Subject::all();

        return view('dashboards.adminfolder.assign_subject', compact('instructors', 'subjects'));
    }
}