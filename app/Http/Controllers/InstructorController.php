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

        return view('dashboards.instructor');
    }
}
