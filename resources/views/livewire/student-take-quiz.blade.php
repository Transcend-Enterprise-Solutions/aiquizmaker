<div class="p-6 bg-white shadow rounded-lg">
    @if (!$showQuiz)
        <h2 class="text-xl font-semibold text-gray-800">Available Quizzes</h2>

        @if ($quizzes->isEmpty())
            <p class="mt-4 text-gray-600">No quizzes are available at the moment.</p>
        @else
            <ul class="mt-4 space-y-3">
                @foreach ($quizzes as $quiz)
                    <li class="bg-gray-100 p-4 rounded-md shadow-sm">
                        <h3 class="text-lg font-medium text-gray-700">{{ $quiz->quiz_name }}</h3>
                        <p class="text-sm text-gray-500">Duration: {{ $quiz->duration }} minutes</p>
                        <p class="text-sm text-gray-500">Available: {{ $quiz->start_date }} to {{ $quiz->end_date }}</p>
                        <button wire:click="startQuiz({{ $quiz->id }})" 
                                class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Take Quiz
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    @else
        <h2 class="text-xl font-semibold text-gray-800">Quiz: {{ $currentQuiz->quiz_name }}</h2>
        <form wire:submit.prevent="submitAnswers" class="mt-4">
            <ul class="space-y-6">
                @foreach ($questions as $index => $question)
                    <li class="p-4 bg-gray-100 rounded-md shadow">
                        <h4 class="font-medium text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h4>
                        @foreach (json_decode($question->option, true) as $key => $option)
                            <div class="mt-2">
                                <label>
                                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $key }}" />
                                    {{ $option }}
                                </label>
                            </div>
                        @endforeach
                    </li>
                @endforeach
            </ul>
            <button type="submit" 
                    class="mt-6 px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Submit Quiz
            </button>
        </form>
    @endif
</div>
