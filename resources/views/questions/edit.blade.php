@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-6 max-w-screen-md py-12">
    <h1 class="text-3xl font-bold mb-6">Edit Question</h1>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('questions.update', $question) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Question -->
        <div>
            <label for="question" class="block text-gray-700 font-medium">Question</label>
            <textarea id="question" name="question" rows="4" required class="w-full border rounded p-2 mt-2">{{ old('question', $question->question) }}</textarea>
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-gray-700 font-medium">Question Type</label>
            <select id="type" name="type" required class="w-full border rounded p-2 mt-2">
                <option value="true_false" {{ old('type', $question->type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                <option value="multiple_choice" {{ old('type', $question->type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
            </select>
        </div>

        <!-- Options -->
        <div x-data="{ type: '{{ old('type', $question->type) }}' }">
            <template x-if="type == 'multiple_choice'">
                <div>
                    <label class="block text-gray-700 font-medium">Options</label>
                    @php $options = json_decode(old('options', $question->option), true); @endphp
                    <div class="space-y-2 mt-2">
                        @for ($i = 0; $i < 4; $i++)
                            <input type="text" name="options[]" value="{{ $options[$i] ?? '' }}" class="w-full border rounded p-2" placeholder="Option {{ $i + 1 }}">
                        @endfor
                    </div>
                </div>
            </template>
        </div>

        <!-- Correct Answer -->
        <div>
            <label for="correct_answer" class="block text-gray-700 font-medium">Correct Answer</label>
            <input id="correct_answer" type="text" name="correct_answer" value="{{ old('correct_answer', $question->correct_answer) }}" required class="w-full border rounded p-2 mt-2">
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="bg-indigo-500 text-white px-6 py-2 rounded shadow hover:bg-indigo-600">
                Save Changes
            </button>
        </div>
    </form>

    <!-- Back Button -->
    <div class="mt-4">
        <a href="{{ route('quiz.view', $question->quiz_id) }}" class="text-indigo-500 hover:underline">Back</a>
    </div>
</div>
@endsection
