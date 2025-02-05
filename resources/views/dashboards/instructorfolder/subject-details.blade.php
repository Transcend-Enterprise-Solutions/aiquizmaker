@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h1 class="text-2xl font-bold">{{ $subject->name }}</h1>
    <p class="text-gray-600">{{ $subject->description ?? 'No description available' }}</p>

    <!-- Back Button -->
    <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
        Back to Subjects
    </a>

    <!-- Quizzes Section -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Quizzes</h2>
        @if ($subject->quizzes->isEmpty())
            <p class="text-gray-500">No quizzes available for this subject.</p>
        @else
            <ul class="space-y-2">
                @foreach ($subject->quizzes as $quiz)
                    <li class="p-2 border rounded-lg shadow">
                        <strong>{{ $quiz->name }}</strong> - {{ $quiz->questions->count() }} questions
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- Student Stats Section -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Student Performance</h2>
        @if ($subject->students->isEmpty())
            <p class="text-gray-500">No students enrolled in this subject.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-2">Student</th>
                        <th class="border p-2">Completed Quizzes</th>
                        <th class="border p-2">Average Score</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subject->students as $student)
                        <tr class="border-t">
                            <td class="border p-2">{{ $student->name }}</td>
                            <td class="border p-2">{{ $student->quizzes->count() }} quizzes</td>
                            <td class="border p-2">
                                {{ $student->quizzes->avg('pivot.score') ?? 'N/A' }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
