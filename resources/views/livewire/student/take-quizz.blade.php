<div class="p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-semibold text-gray-800">Quiz: {{ $quiz->quiz_name }}</h2>
    <p class="text-sm text-gray-600">Duration: {{ $quiz->duration }} minutes</p>
    <p class="text-sm text-gray-600">Available: {{ $quiz->start_date }} to {{ $quiz->end_date }}</p>

    <form wire:submit.prevent="submitQuiz" class="mt-4 space-y-6">
        @foreach ($questions as $index => $question)
            <div class="p-4 bg-gray-100 rounded-md shadow">
                <h3 class="font-medium text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h3>
                @php
                    // Decode the options and handle True/False questions explicitly
                    $options = json_decode($question->option, true);
                    if ($question->type === 'True/False') {
                        $options = ["True", "False"]; // Force True/False options
                    }
                @endphp
                @foreach ($options as $key => $option)
                    <label class="block mt-2">
                        <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $key }}">
                        {{ $option }}
                    </label>
                @endforeach
            </div>
        @endforeach

        <button type="submit"
                class="mt-6 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Submit Quiz
        </button>
    </form>
</div>
