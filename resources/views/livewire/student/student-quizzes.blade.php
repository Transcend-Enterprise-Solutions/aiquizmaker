<div class="p-6 bg-gray-50 border border-gray-200 rounded-lg">
    <h2 class="text-2xl font-bold text-blue-800">Your Quizzes</h2>

    @if ($subjects->isEmpty())
        <div class="mt-6 flex items-center justify-center">
            <p class="text-lg text-gray-600">You are not enrolled in any subjects with available quizzes.</p>
        </div>
    @else
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach ($subjects as $subject)
    <div class="p-4 bg-white border border-gray-300 rounded-lg shadow">
        <h3 class="text-lg font-semibold text-gray-700">{{ $subject->name }}</h3>

        @if ($subject->quizLists->isEmpty())
            <p class="mt-2 text-sm text-gray-500">No quizzes available for this subject.</p>
        @else
            <ul class="mt-4 space-y-4">
                @foreach ($subject->quizLists as $quiz)
                    @php
                        $alreadyTaken = \App\Models\StudentQuizResult::where('student_id', auth()->id())
                            ->where('quiz_id', $quiz->quiz_id)
                            ->exists();
                    @endphp
                    <li class="p-4 bg-gray-100 border border-gray-200 rounded-md">
                        <h4 class="text-md font-semibold text-gray-800">{{ $quiz->quiz_name }}</h4>
                        <p class="text-sm text-gray-500">Duration: {{ $quiz->duration }} minutes</p>
                        <p class="text-sm text-gray-500">
                            Available: {{ $quiz->start_date }} to {{ $quiz->end_date }}
                        </p>
                        
                        @if ($alreadyTaken)
                            <span class="mt-3 inline-block px-5 py-2 bg-gray-400 text-white font-medium rounded-lg">
                                Completed
                            </span>
                        @else
                            <a href="{{ route('student.takeQuiz', ['quizId' => $quiz->quiz_id]) }}" 
                            class="mt-3 inline-block px-5 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                                Take Quiz
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endforeach
        </div>
    @endif
</div>
