<!-- resources/views/edit-questions.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold">Edit Questions</h1>
    <form id="questions-form" method="POST" action="{{ route('save.questions') }}">
        @csrf
        @foreach($questions as $index => $question)
            <div class="question-item border rounded p-4 my-4">
                <label for="question_{{ $index }}" class="block font-bold mb-2">Question:</label>
                <textarea id="question_{{ $index }}" name="questions[{{ $index }}][question]" class="question-input w-full p-2 border rounded">{{ $question['question'] }}</textarea>

                <label class="block font-bold mt-4 mb-2">Options:</label>
                @foreach($question['options'] as $optionIndex => $option)
                    <div class="flex items-center gap-2">
                        <input
                            type="text"
                            name="questions[{{ $index }}][options][{{ $optionIndex }}]"
                            value="{{ $option }}"
                            class="option-input flex-grow p-2 border rounded">
                        <span>Option {{ chr(97 + $optionIndex) }}</span>
                    </div>
                @endforeach

                <label for="answer_{{ $index }}" class="block font-bold mt-4 mb-2">Answer:</label>
                <textarea id="answer_{{ $index }}" name="questions[{{ $index }}][answer]" class="answer-input w-full p-2 border rounded">{{ $question['answer'] }}</textarea>
            </div>
        @endforeach
        <button type="submit" class="save-button bg-blue-500 text-white px-4 py-2 rounded mt-4">Save Changes</button>
    </form>
</div>
@endsection
