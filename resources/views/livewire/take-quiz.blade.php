<div>
    <h1 class="text-2xl font-bold mb-4">Take the Quiz</h1>

    @if ($submitted)
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            <h2 class="text-lg font-bold">Your Score: {{ $score }} / {{ count($questions) }}</h2>
        </div>
    @else
        <form wire:submit.prevent="submitQuiz" class="space-y-4">
            @foreach ($questions as $index => $question)
                <div class="p-4 border rounded mb-4">
                    <p class="font-bold">{{ $index + 1 }}. {{ $question->question }}</p>

                    @php $options = json_decode($question->options, true); @endphp

                    @foreach ($options as $optionIndex => $option)
                        @if ($option)
                            <label class="block">
                                <input type="radio" wire:model="answers.{{ $index }}" value="{{ $option }}"
                                    class="mr-2">
                                {{ $option }}
                            </label>
                        @endif
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Submit Quiz
            </button>
        </form>
    @endif
</div>
