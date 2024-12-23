<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'student') {
            abort(403, 'Unauthorized');
        }

        return view('dashboards.student');
    }
}
