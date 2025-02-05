<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    
}
