@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-center mb-6">Generated Questions</h1>
    <form method="POST" action="{{ route('save.questions') }}">
        @csrf
        <div class="space-y-6">
            @foreach ($questions as $index => $question)
                <div 
                    x-data="{ isEditing: false }" 
                    class="p-6 mb-6 border rounded-lg shadow-lg bg-gradient-to-r from-gray-50 via-gray-100 to-gray-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800"
                >
                    <!-- Question Header -->
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
                            Question {{ $index + 1 }}
                        </h2>
                        <button 
                            type="button" 
                            @click="isEditing = !isEditing" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300 dark:focus:ring-blue-600 transition"
                        >
                            <span x-show="!isEditing">Edit</span>
                            <span x-show="isEditing">Cancel</span>
                        </button>
                    </div>

                    <!-- Editable Question Text -->
                    <div class="mb-4">
                        <textarea 
                            x-show="isEditing" 
                            name="questions[{{ $index }}][question]" 
                            class="w-full p-4 border rounded-lg focus:ring focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-900 dark:border-gray-700 text-gray-800 dark:text-gray-200"
                            placeholder="Enter the question text here"
                        >{{ $question['question'] }}</textarea>

                        <p 
                            x-show="!isEditing" 
                            class="text-gray-700 dark:text-gray-300 border-b pb-2"
                        >
                            {{ $question['question'] }}
                        </p>
                    </div>

                    <!-- Options -->
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">Options:</h3>
                        <div class="space-y-4">
                            @foreach ($question['options'] as $optionIndex => $option)
                                <div class="flex items-center gap-4">
                                    <!-- Radio Button -->
                                    <input 
                                        type="radio" 
                                        name="questions[{{ $index }}][answer]" 
                                        value="{{ $option }}" 
                                        id="option_{{ $index }}_{{ $optionIndex }}"
                                        @if (trim($option) === trim($question['answer'])) checked @endif
                                        class="h-5 w-5 text-blue-500 focus:ring focus:ring-blue-300 dark:focus:ring-blue-600"
                                    >

                                    <!-- Editable Option -->
                                    <div class="flex-1">
                                        <input 
                                            x-show="isEditing" 
                                            type="text" 
                                            name="questions[{{ $index }}][options][{{ $optionIndex }}]" 
                                            value="{{ $option }}" 
                                            class="w-full p-3 border rounded-lg focus:ring focus:ring-blue-300 dark:focus:ring-blue-600 dark:bg-gray-900 dark:border-gray-700 text-gray-800 dark:text-gray-200"
                                            placeholder="Option {{ chr(65 + $optionIndex) }}"
                                        >
                                        <span 
                                            x-show="!isEditing" 
                                            class="text-gray-700 dark:text-gray-300"
                                        >
                                            {{ chr(65 + $optionIndex) }}. {{ $option }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <button type="submit" class="mt-6 px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300 dark:focus:ring-green-600 transition">
            Save Questions
        </button>
    </form>
</div>
@endsection
