@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Review Your Quiz</h2>

    @foreach ($quiz->questions as $index => $question)
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h3>

            @php
                // Decode options and handle fallback
                $options = $question->option;

                // Step 1: Ensure $options is a string and remove excessive escaping
                if (is_string($options)) {
                    $options = stripslashes($options); // Remove extra backslashes
                    $decodedOptions = json_decode($options, true); // Attempt to decode JSON

                    // Step 2: Check if JSON decoding succeeded
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decodedOptions)) {
                        $options = $decodedOptions; // Successfully decoded
                    } else {
                        // Step 3: Handle improperly formatted options
                        $options = preg_replace('/\\\\+/', '', $options); // Remove stray backslashes
                        $options = preg_replace('/^\[|\]$/', '', $options); // Remove surrounding square brackets
                        $options = explode('","', trim($options, '"')); // Split into an array
                        $options = array_map(function ($option) {
                            return trim($option, '"'); // Remove quotes from each option
                        }, $options);
                    }
                }

                // Step 4: Ensure $options is always an array
                if (!is_array($options)) {
                    $options = [];
                }

                // Step 5: Format the options for display
                $options = array_map(function ($option) {
                    return '"' . $option . '"'; // Add double quotes around each option
                }, $options);





                $userAnswerKey = $attempts[$index]->answer ?? null; // User's selected answer key
                $userAnswerText = $userAnswerKey !== null ? $options[$userAnswerKey] ?? 'N/A' : 'N/A'; // Map key to text
                $correctAnswer = $question->correct_answer; // Correct answer
            @endphp

            <div class="mt-4 space-y-2">
                @foreach ($options as $key => $option)
                    @php
                        // Determine styling for answers
                        $isUserAnswer = ($userAnswerKey !== null && $userAnswerKey == $key);
                        $isCorrectAnswer = (trim($correctAnswer, '"') == trim($option, '"'));
                        $answerClass = '';

                        if ($isUserAnswer && $isCorrectAnswer) {
                            $answerClass = 'bg-green-200 text-green-800 font-semibold'; // User selected & correct
                        } elseif ($isUserAnswer) {
                            $answerClass = 'bg-red-200 text-red-800 font-semibold'; // User selected & incorrect
                        } elseif ($isCorrectAnswer) {
                            $answerClass = 'bg-green-200 text-green-800'; // Correct answer but not selected
                        }
                    @endphp

                    <label class="block p-2 rounded {{ $answerClass }}">
                        <input type="radio" disabled {{ $isUserAnswer ? 'checked' : '' }}>
                        {{ $option }}
                    </label>
                @endforeach
            </div>

            <p class="mt-4 text-sm">
            Your answer: <strong>{{ $attempts[$index]->answer }}</strong>
                @if ($attempts[$index]->null)
                    <span class="text-gray-500">(Not Answered)</span>
                @elseif ($attempts[$index]->is_correct)
                    <span class="text-green-500">Correct</span>
                @else
                    <span class="text-red-500">Incorrect</span>
                @endif
            </p>

            <p class="mt-2 text-sm">
                Correct answer: <strong>{{ $correctAnswer }}</strong>
            </p>
        </div>
    @endforeach
</div>
@endsection
