@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <!-- Quiz Name -->
    <h1 class="text-2xl font-bold mb-6">Quiz: {{ $quiz->name }}</h1>

    <!-- Quiz Description -->
    <p class="text-gray-600 mb-4">{{ $quiz->description ?? 'No description available.' }}</p>

    <!-- Students and Scores -->
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-xl font-semibold mb-4">Student Performance</h2>

        @if ($studentResults->isEmpty())
            <p class="text-gray-500">No students have taken this quiz yet.</p>
        @else
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Student Name</th>
                        <th class="border px-4 py-2">Score</th>
                        <th class="border px-4 py-2">Percentage</th>
                        <th class="border px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($studentResults as $result)
                        <tr class="border-t">
                            <td class="border px-4 py-2">{{ $result->student->name }}</td>
                            <td class="border px-4 py-2">{{ $result->score }}</td>
                            <td class="border px-4 py-2">{{ $result->percentage }}%</td>
                            <td class="border px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-white {{ $result->status == 'Pass' ? 'bg-green-500' : 'bg-red-500' }}">
                                    {{ $result->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Back Button -->
    <a href="{{ route('quizzes.index') }}" class="mt-6 px-6 py-3 bg-gray-500 text-white font-medium rounded-lg shadow hover:bg-gray-600">
        Back to Quizzes
    </a>
</div>
@endsection
