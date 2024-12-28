@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Generate Questions</h1>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('questions.generate') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="topic" class="block font-bold mb-2">Topic or Prompt:</label>
            <input type="text" name="topic" id="topic" class="w-full border-gray-300 rounded-lg p-2" placeholder="Enter a topic or prompt" required>
        </div>

        <div>
            <label for="difficulty" class="block font-bold mb-2">Difficulty Level:</label>
            <select name="difficulty" id="difficulty" class="w-full border-gray-300 rounded-lg p-2" required>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>

        <div>
            <label for="numberOfQuestions" class="block font-bold mb-2">Number of Questions:</label>
            <input type="number" name="numberOfQuestions" id="numberOfQuestions" class="w-full border-gray-300 rounded-lg p-2" min="1" max="50" placeholder="Enter a number (1-50)" required>
        </div>

        <div>
            <label for="questionType" class="block font-bold mb-2">Question Type:</label>
            <select name="questionType" id="questionType" class="w-full border-gray-300 rounded-lg p-2" required>
                <option value="multiple_choice">Multiple Choice</option>
                <option value="true_false">True/False</option>
                <option value="short_answer">Short Answer</option>
            </select>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">
            Generate Questions
        </button>
    </form>
</div>
@endsection
