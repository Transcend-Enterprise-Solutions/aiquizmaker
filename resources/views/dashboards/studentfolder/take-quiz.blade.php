@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 max-w-screen-lg py-12" x-data="quizTimer({{ $quiz->duration }})" x-init="initTimer()">
    <!-- Quiz Title -->
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ $quiz->quiz_name }}</h2>

    <!-- Timer -->
    <p class="mb-4 text-gray-600">
        Time Remaining: <span x-text="formattedTime" class="font-semibold"></span>
    </p>

    <!-- No Questions Message -->
    @if ($quiz->questions->isEmpty())
        <p class="text-center text-gray-500">There are no questions available for this quiz.</p>
    @else
        <!-- Quiz Form -->
        <form id="quizForm" action="{{ route('student.submitQuiz', ['quizId' => $quiz->quiz_id]) }}" method="POST">
            @csrf

            <!-- Questions Loop -->
            <div class="space-y-6">
                @foreach ($quiz->questions as $index => $question)
                @php
                    // Ensure options are correctly formatted as an array
                    $options = json_decode($question->option, true);

                    // If json_decode() fails, fallback to an empty array
                    if (!is_array($options)) {
                        $options = [];
                    }
                @endphp
                    
                    <!-- Question Card -->
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <!-- Question Text -->
                        <h3 class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h3>

                        <!-- Options Loop -->
                        <div class="mt-4 space-y-2">
                            @foreach ($options as $key => $option)
                                <label class="block">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" required class="mr-2">
                                    {{ $option }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                Submit Quiz
            </button>
        </form>
    @endif
</div>

<!-- Alpine.js Timer Script -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quizTimer', (duration) => ({
            timeRemaining: duration * 60, // Convert minutes to seconds
            formattedTime: '00:00',

            initTimer() {
                this.updateTimer();
                const interval = setInterval(() => {
                    this.timeRemaining--;
                    this.updateTimer();

                    // Auto-submit when time runs out
                    if (this.timeRemaining <= 0) {
                        clearInterval(interval);
                        alert('Time is up!');
                        document.getElementById('quizForm').submit();
                    }
                }, 1000);
            },

            updateTimer() {
                const minutes = Math.floor(this.timeRemaining / 60);
                const seconds = this.timeRemaining % 60;
                this.formattedTime = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
        }));
    });
</script>
@endsection