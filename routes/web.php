<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\InstructorController;


Route::post('/logout', function () {
    auth()->logout();
    return redirect('/');
})->name('logout');



Route::get('/dashboard', function () {
    if (auth()->user()->role === 'student') {
        return redirect()->route('student.dashboard');
    } elseif (auth()->user()->role === 'instructor') {
        return redirect()->route('instructor.dashboard');
    } else {
        abort(403, 'Unauthorized');
    }
})->middleware('auth');

// Student Dashboard
Route::get('/student-dashboard', [StudentController::class, 'index'])
    ->name('student.dashboard')
    ->middleware('auth');

// Instructor Dashboard
Route::get('/instructor-dashboard', [InstructorController::class, 'index'])
    ->name('instructor.dashboard')
    ->middleware('auth');


    
Route::get('/', function () {
    return view('welcome');
});
