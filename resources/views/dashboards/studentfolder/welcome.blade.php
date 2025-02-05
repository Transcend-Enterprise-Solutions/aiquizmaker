@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">

    <!-- Dashboard Heading -->
    <h1 class="text-2xl font-bold flex items-center space-x-2">
        <svg class="w-8 h-8 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span>Student Portal</span>
    </h1>
    <p class="text-gray-600">Welcome, {{ Auth::user()->name }}! Here’s your academic performance summary.</p>

    <!-- Quick Stats Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
        
        <!-- 📘 Courses Enrolled -->
        <div class="bg-white p-4 rounded-lg shadow-md flex items-center space-x-4">
            <svg class="w-12 h-12 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
            <div>
                <h3 class="text-lg font-semibold">Courses Enrolled</h3>
                <p class="text-gray-600 text-2xl">{{ $totalCourses }}</p>
            </div>
        </div>

        <!-- 📝 Quizzes Taken -->
        <div class="bg-white p-4 rounded-lg shadow-md flex items-center space-x-4">
            <svg class="w-12 h-12 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            <div>
                <h3 class="text-lg font-semibold">Quizzes Taken</h3>
                <p class="text-gray-600 text-2xl">{{ $quizzesTaken }}</p>
            </div>
        </div>

        <!-- 📊 Average Score -->
        <div class="bg-white p-4 rounded-lg shadow-md flex items-center space-x-4">
            <svg class="w-12 h-12 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <div>
                <h3 class="text-lg font-semibold">Average Score</h3>
                <p class="text-gray-600 text-2xl">{{ number_format($averageScore, 2) }}%</p>
            </div>
        </div>

        <!-- 🏆 Pass Rate -->
        <div class="bg-white p-4 rounded-lg shadow-md flex items-center space-x-4">
            <svg class="w-12 h-12 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v13m0-13V4m0 9h9m-9 0H3m9 5v5m0-5V8m0 5h5m-5 0H3" />
            </svg>
            <div>
                <h3 class="text-lg font-semibold">Pass Rate</h3>
                <p class="text-gray-600 text-2xl">{{ $passPercentage }}%</p>
            </div>
        </div>

    </div>

    <!-- Upcoming Quizzes Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mt-6">
        <h3 class="text-xl font-semibold flex items-center space-x-2">
            <svg class="w-8 h-8 text-gray-500 hover:text-gray-700 transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Upcoming Quizzes</span>
        </h3>
        <ul>
            @forelse($upcomingQuizzes as $subject)
                @foreach($subject->quizLists as $quiz)
                    <li class="mb-2">
                        <strong>{{ $quiz->quiz_name }}</strong> - 
                        {{ \Carbon\Carbon::parse($quiz->start_date)->format('M d, Y h:i A') }}
                    </li>
                @endforeach
            @empty
                <p class="text-gray-500">No upcoming quizzes.</p>
            @endforelse
        </ul>
    </div>

</div>
@endsection