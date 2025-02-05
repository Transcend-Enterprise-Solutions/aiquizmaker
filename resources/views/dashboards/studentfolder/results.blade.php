@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your Quiz Results</h2>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-600 uppercase text-sm">
            <tr>
                <th class="py-3 px-6 text-left">Quiz</th>
                <th class="py-3 px-6 text-center">Score</th>
                <th class="py-3 px-6 text-center">Percentage</th>
                <th class="py-3 px-6 text-center">Status</th>
                <th class="py-3 px-6 text-center">Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($results as $result)
                <tr class="border-b">
                    <td class="py-3 px-6 text-left">{{ $result->quiz->quiz_name }}</td>
                    <td class="py-3 px-6 text-center">{{ $result->score }} / {{ $result->total_questions }}</td>
                    <td class="py-3 px-6 text-center">{{ $result->percentage }}%</td>
                    <td class="py-3 px-6 text-center {{ $result->status == 'Pass' ? 'text-green-500' : 'text-red-500' }}">
                        {{ $result->status }}
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('student.reviewQuiz', ['quizId' => $result->quiz_id]) }}" class="text-blue-600 hover:text-blue-800">
                            Review
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
