@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 max-w-screen-lg py-12" x-data="quizTimer({{ $quiz->duration }})" x-init="initTimer()">
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">{{ $quiz->quiz_name }}</h2>
    <p class="mb-4 text-gray-600">
        Time Remaining: <span x-text="formattedTime"></span>
    </p>

    @if ($quiz->questions->isEmpty())
        <p class="text-center text-gray-500">There are no questions available for this quiz.</p>
    @else
        <form id="quizForm" action="{{ route('student.submitQuiz', ['quizId' => $quiz->quiz_id]) }}" method="POST">
            @csrf

            <div class="space-y-6">
                @foreach ($quiz->questions as $index => $question)
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h3 class="font-semibold text-gray-800">{{ $index + 1 }}. {{ $question->question }}</h3>
                        <div class="mt-4 space-y-2">
                        @foreach (json_decode($question->option, true) as $key => $option)
                            <label class="block">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" required>
                                {{ $option }}
                            </label>
                        @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Submit Quiz
            </button>
        </form>
    @endif
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quizTimer', (duration) => ({
            durationInSeconds: duration * 60, // Convert minutes to seconds
            remainingTime: 0, // Will be initialized dynamically
            startTimeKey: 'quizStartTime_{{ $quiz->quiz_id }}',

            initTimer() {
                const savedStartTime = localStorage.getItem(this.startTimeKey);

                if (savedStartTime) {
                    // Calculate the remaining time
                    const elapsedTime = Math.floor((Date.now() - parseInt(savedStartTime)) / 1000);
                    this.remainingTime = Math.max(this.durationInSeconds - elapsedTime, 0);
                } else {
                    // First-time quiz start
                    localStorage.setItem(this.startTimeKey, Date.now());
                    this.remainingTime = this.durationInSeconds;
                }

                // Start the countdown
                this.startCountdown();
            },

            startCountdown() {
                const interval = setInterval(() => {
                    if (this.remainingTime > 0) {
                        this.remainingTime--;
                    } else {
                        clearInterval(interval);
                        this.submitQuiz();
                    }
                }, 1000);
            },

            get formattedTime() {
                const minutes = Math.floor(this.remainingTime / 60);
                const seconds = this.remainingTime % 60;
                return `${minutes}:${seconds.toString().padStart(2, '0')}`;
            },

            submitQuiz() {
                // Automatically submit the form
                localStorage.removeItem(this.startTimeKey); // Clean up localStorage
                document.getElementById('quizForm').submit();
            }
        }));
    });
</script>
@endsection
