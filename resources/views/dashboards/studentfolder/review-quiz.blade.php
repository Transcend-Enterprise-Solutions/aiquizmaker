@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Review Your Quiz</h2>

    @foreach ($quiz->questions as $index => $question)
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h3>

            <div class="mt-4 space-y-2">
                @foreach (json_decode($question->option, true) as $key => $option)
                    <label class="block">
                        <input type="radio" disabled {{ isset($attempts[$index]) && $attempts[$index]->answer == $key ? 'checked' : '' }}>
                        {{ $option }}
                    </label>
                @endforeach
            </div>

            <p class="mt-4 text-sm">
                Your answer: <strong>{{ $attempts[$index]->answer }}</strong>
                @if ($attempts[$index]->is_correct)
                    <span class="text-green-500">Correct</span>
                @else
                    <span class="text-red-500">Incorrect</span>
                @endif
            </p>

            <p class="mt-2 text-sm">
                Correct answer: <strong>{{ $question->correct_answer }}</strong>
            </p>
        </div>
    @endforeach
</div>
@endsection
