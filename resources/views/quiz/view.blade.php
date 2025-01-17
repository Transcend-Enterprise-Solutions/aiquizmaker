@extends('layouts.app') <!-- Let’s start with a solid base -->

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-16 max-w-screen-xl pt-20">
    <!-- Quiz Header -->
    <section class="relative bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-3xl shadow-xl p-12">
        <div class="absolute inset-0 bg-gradient-to-br from-black/30 via-transparent to-black/40 rounded-3xl"></div>
        <div class="relative z-10 space-y-6 max-w-4xl">
            <h1 class="text-5xl font-extrabold leading-tight tracking-tight">
                {{ $quiz->quiz_name }}
            </h1>
            <p class="text-lg font-medium">
                This quiz will take approximately 
                <span class="font-semibold">{{ $quiz->duration }} minutes</span>. Let’s see how much you know!
            </p>
            <div class="flex flex-wrap gap-4 text-sm sm:text-base">
                <div class="bg-white/20 text-white px-5 py-2 rounded-full">
                    Quiz Set: <span class="font-bold">{{ $quiz->quiz_set ?? 'Not Available' }}</span>
                </div>
                <div class="bg-white/20 text-white px-5 py-2 rounded-full">
                    Last Updated: <span class="font-bold">{{ $quiz->updated_at->format('F j, Y') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Questions Section -->
    <section>
        <header class="mb-12">
            <h2 class="text-4xl font-bold text-gray-800">Questions</h2>
            <p class="text-gray-600">
                Carefully review each question and test your knowledge.
            </p>
        </header>

        @if ($quiz->quizzes->isEmpty())
            <div class="bg-yellow-100 border-l-4 border-yellow-400 p-6 rounded-lg">
                <p class="text-yellow-800 font-semibold">
                    No questions available yet. Check back later!
                </p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($quiz->quizzes as $index => $question)
                    <!-- Question Card -->
                    <div x-data="{ open: false }" class="bg-white rounded-xl shadow-lg p-6 hover:shadow-xl transition">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">
                                    Question {{ $index + 1 }}
                                </h3>
                                <p class="text-gray-700 mt-2">
                                    {{ Str::limit($question->question, 80, '...') }}
                                </p>
                            </div>
                            <button
                                @click="open = !open"
                                class="text-indigo-600 hover:text-indigo-800 font-medium"
                            >
                                <span x-show="!open">Details</span>
                                <span x-show="open" x-cloak>Hide</span>
                            </button>
                        </div>

                        <!-- Question Details -->
                        <div x-show="open" x-collapse class="mt-4">
                            @php
                                $options = json_decode($question->option, true);
                            @endphp

                            @if (is_array($options) && count($options))
                                <ul class="space-y-2">
                                    @foreach ($options as $key => $option)
                                        <li class="text-gray-600">
                                            <span class="font-semibold">Option {{ $key + 1 }}:</span>
                                            {{ $option ?? 'N/A' }}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-gray-500 mt-2">No options provided for this question.</p>
                            @endif

                            <p class="text-green-600 font-medium mt-4">
                                Correct Answer: <span class="font-bold">{{ $question->correct_answer }}</span>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Back Button -->
    <section class="text-center">
        <a href="{{ url()->previous() }}" class="inline-block bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-medium px-8 py-3 rounded-full shadow-lg hover:scale-105 transition">
            Back to Quizzes
        </a>
    </section>
</div>
@endsection
