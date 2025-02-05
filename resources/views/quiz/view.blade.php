@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-16 max-w-screen-xl pt-20">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="bg-green-500 text-white text-center py-2 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-500 text-white text-center py-2 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <!-- Quiz Header -->
    <section class="relative bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-3xl shadow-xl p-8 md:p-12">
        <h1 class="text-3xl md:text-5xl font-extrabold">{{ $quiz->quiz_name }}</h1>
        <p class="text-base md:text-lg font-medium">Duration: {{ $quiz->duration }} minutes</p>
        @if ($quiz->quiz_set)
            <p class="text-base md:text-lg font-medium">Quiz Set: {{ $quiz->quiz_set }}</p>
        @endif
    </section>

    <!-- Questions Section -->
    <section>
        <header class="mb-8 md:mb-12">
            <h2 class="text-2xl md:text-4xl font-bold text-gray-800">Questions</h2>
        </header>

        @if ($quiz->questions && $quiz->questions->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($quiz->questions as $question)
                    <div class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $question->question }}</h3>
                        <ul class="mt-3 space-y-2">
                        @php
                            $options = is_array($question->option) ? $question->option : json_decode($question->option, true) ?? [];
                        @endphp


                            @foreach($options as $option)
                                <li class="flex items-center space-x-2">
                                    <input type="radio" {{ $question->correct_answer === $option ? 'checked' : '' }} disabled>
                                    <span>{{ $option }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="flex space-x-3 mt-4">
                            <!-- Edit Button -->
                            <button onclick="document.getElementById('edit-{{ $question->id }}').style.display='block'"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-colors">
                                Edit
                            </button>

                            <!-- Delete Form -->
                            <form action="{{ route('questions.destroy', $question->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this question?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                    Delete
                                </button>
                            </form>
                        </div>

                        <!-- Edit Mode (Hidden by Default) -->
                        <div id="edit-{{ $question->id }}" class="hidden mt-4">
                            <form action="{{ route('questions.update', $question->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Question</label>
                                    <input type="text" name="question" value="{{ old('question', $question->question) }}" 
                                           class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                                </div>

                                <div class="mb-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Options</label>

                                    @foreach(old('options', $options) as $index => $option)
                                        <div class="flex items-center space-x-2 mb-2">
                                            <input type="radio" name="correct_answer" value="{{ $option }}" 
                                                   {{ old('correct_answer', $question->correct_answer) === $option ? 'checked' : '' }}>
                                            <input type="text" name="options[]" value="{{ $option }}" 
                                                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="flex space-x-3 pt-4">
                                    <button type="submit"
                                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition-colors">
                                        Save Changes
                                    </button>
                                    <button type="button" onclick="document.getElementById('edit-{{ $question->id }}').style.display='none'"
                                            class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition-colors">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl p-6 shadow-lg text-center text-gray-500">
                No questions available for this quiz.
            </div>
        @endif
    </section>
</div>
@endsection
