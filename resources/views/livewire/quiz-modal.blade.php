<div x-data="{ open: @entangle('quiz') }" x-show="open" 
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg shadow-lg max-w-2xl w-full p-6 space-y-4">
        <!-- Modal Header -->
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-bold">{{ $quiz->quiz_name ?? '' }}</h2>
            <button @click="open = false" wire:click="$set('quiz', null)" class="text-gray-500">&times;</button>
        </div>

        <!-- Quiz Details -->
        @if ($quiz)
            <div class="space-y-4">
                <!-- Quiz Card -->
                <div class="bg-gray-50 p-4 rounded shadow-sm">
                    <h3 class="font-semibold text-lg">{{ $quiz->quiz_name }}</h3>
                    <p class="text-sm text-gray-600">
                        Last Updated: {{ $quiz->updated_at->format('F j, Y') }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Duration: {{ $quiz->duration }} minutes
                    </p>
                    <p class="text-sm text-gray-600">
                        Quiz Set: {{ $quiz->quiz_set }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Total Questions: {{ $quiz->quizzes->count() }} questions
                    </p>
                </div>

                <!-- Questions List -->
                <div class="space-y-2">
                    <h4 class="text-md font-bold text-gray-700">Questions:</h4>
                    <ul class="list-disc pl-5 space-y-2">
                        @foreach ($quiz->quizzes as $index => $question)
                            <li class="text-gray-700">
                                <span class="font-semibold">Q{{ $index + 1 }}:</span> {{ $question->question }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Modal Footer -->
        <div class="text-right">
            <button @click="open = false" wire:click="$set('quiz', null)" 
                class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Close
            </button>
        </div>
    </div>
</div>
