<div class="mt-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Generated Questions</h2>

    @if($questions && count($questions))
        <ul class="space-y-4">
            @foreach($questions as $index => $question)
                <li class="p-4 border rounded-lg bg-white dark:bg-gray-800 shadow">
                    <h3 class="font-medium">{{ $index + 1 }}. {{ $question['question'] }}</h3>
                    <button 
                        wire:click="$emit('toggleAnswer', {{ $index }})" 
                        class="mt-2 text-blue-500 hover:underline"
                    >
                        Show Answer
                    </button>
                    <p id="answer-{{ $index }}" class="hidden mt-2 text-gray-600 dark:text-gray-400">
                        {{ $question['answer'] }}
                    </p>
                </li>
            @endforeach
        </ul>
    @else
        <p>No questions generated yet. Use the form above to generate questions.</p>
    @endif
</div>
