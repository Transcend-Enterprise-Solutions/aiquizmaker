@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-16 max-w-screen-xl pt-20">
    <!-- Quiz Header -->
    <section class="relative bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-3xl shadow-xl p-12">
        <h1 class="text-5xl font-extrabold">{{ $quiz->quiz_name }}</h1>
        <p class="text-lg font-medium">Duration: {{ $quiz->duration }} minutes</p>
        @if ($quiz->quiz_set)
            <p class="text-lg font-medium">Quiz Set: {{ $quiz->quiz_set }}</p>
        @endif
    </section>

    <!-- Questions Section -->
    <section>
        <header class="mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Questions</h2>
        </header>

        @if ($quiz->quizzes && $quiz->quizzes->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($quiz->quizzes as $question)
                    <div x-data="questionEditor({{ json_encode($question) }})" class="bg-white rounded-xl shadow-lg p-6">
                        <!-- View Mode -->
                        <div x-show="!isEditing">
                            <h3 class="text-lg font-semibold text-gray-900" x-text="data.question"></h3>
                            <ul class="mt-4">
                                <template x-for="(option, index) in data.options" :key="index">
                                    <li>
                                        <input type="radio" :checked="data.correct_answer === option" disabled>
                                        <span x-text="option"></span>
                                    </li>
                                </template>
                            </ul>
                            <button @click="isEditing = true" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">Edit</button>
                        </div>

                        <!-- Edit Mode -->
                        <div x-show="isEditing" class="space-y-4">
                            <label class="block text-gray-700 font-medium">Question</label>
                            <input type="text" x-model="data.question" class="w-full border rounded p-2">

                            <label class="block text-gray-700 font-medium">Options</label>
                            <template x-for="(option, index) in data.options" :key="index">
                                <div>
                                    <input type="radio" x-model="data.correct_answer" :value="option">
                                    <input type="text" x-model="data.options[index]" class="w-full border rounded p-2">
                                </div>
                            </template>

                            <button @click="save" class="px-4 py-2 bg-green-500 text-white rounded">Save</button>
                            <button @click="isEditing = false" class="px-4 py-2 bg-gray-500 text-white rounded">Cancel</button>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>No questions are available for this quiz.</p>
        @endif
    </section>
</div>

<!-- Alpine.js Script for Question Editing -->
<script>
    function questionEditor(question) {
        return {
            isEditing: false,
            data: {
                id: question.id,
                question: question.question,
                options: JSON.parse(question.option || '[]'), // Ensure options are parsed as an array
                correct_answer: question.correct_answer,
            },
            save() {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/questions/${this.data.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(this.data),
                })
                .then((response) => {
                    if (!response.ok) {
                        return response.json().then((data) => {
                            throw new Error(data.error || 'Failed to save changes');
                        });
                    }
                    return response.json();
                })
                .then(() => {
                    alert('Question updated successfully!');
                    this.isEditing = false;
                })
                .catch((error) => {
                    console.error(error);
                    alert('An error occurred while saving the question.');
                });
            },
        };
    }
</script>
@endsection
