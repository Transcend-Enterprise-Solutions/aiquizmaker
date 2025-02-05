<section class="px-4 sm:px-6 lg:px-4 xl:px-6 pt-4 pb-4 sm:pb-6 lg:pb-4 xl:pb-6 space-y-6">
    <header class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Your Quizzes</h1>
        <button wire:click="$set('showModal', true)" class="hover:bg-light-blue-200 hover:text-light-blue-800 group flex items-center rounded-md bg-light-blue-100 text-light-blue-600 text-sm font-medium px-4 py-2">
            <svg class="group-hover:text-light-blue-600 text-light-blue-500 mr-2" width="12" height="20" fill="currentColor">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 5a1 1 0 011 1v3h3a1 1 0 110 2H7v3a1 1 0 11-2 0v-3H2a1 1 0 110-2h3V6a1 1 0 011-1z"/>
            </svg>
            New Quiz
        </button>
    </header>


    @if ($showModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-lg mx-auto">

            <form wire:submit.prevent="uploadQuiz" enctype="multipart/form-data" class="space-y-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-4">
                    <h3 class="text-xl font-semibold text-gray-800">Upload New Quiz</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Quiz Name -->
                <div>
                    <label for="quizName" class="block text-sm font-medium text-gray-700">Quiz Name</label>
                    <input type="text" id="quizName" wire:model="quizName" placeholder="Enter the quiz name"
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('quizName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Subject Dropdown -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                    <select id="subject" wire:model="subject" class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                        <option value="">Select a subject</option>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                    @error('subject') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Duration -->
                <div>
                    <label for="quizDuration" class="block text-sm font-medium text-gray-700">Duration (in minutes)</label>
                    <input type="number" id="quizDuration" wire:model="quizDuration" placeholder="Enter duration (e.g., 30)"
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('quizDuration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Quiz Set -->
                <div>
                    <label for="quizSet" class="block text-sm font-medium text-gray-700">Quiz Set</label>
                    <input type="text" id="quizSet" wire:model="quizSet" placeholder="Enter the quiz set (e.g., November Quiz 1)"
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('quizSet') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Start Date & Time -->
                <div>
                    <label for="startDate" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                    <input type="datetime-local" id="startDate" wire:model="startDate"
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('startDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- End Date & Time -->
                <div>
                    <label for="endDate" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                    <input type="datetime-local" id="endDate" wire:model="endDate"
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('endDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Upload Quiz CSV -->
                <div>
                    <label for="csvFile" class="block text-sm font-medium text-gray-700">Upload Quiz CSV</label>
                    <input type="file" id="csvFile" wire:model="csvFile" accept=".csv" 
                        class="mt-2 w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-3 text-gray-900">
                    @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <!-- Cancel Button -->
                    <button 
                        type="button" 
                        wire:click="$set('showModal', false)" 
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 transition">
                        Cancel
                    </button>

                    <!-- Upload Button -->
                    <!-- Upload Button -->
                    <button 
                        type="submit"
                        wire:loading.attr="disabled" 
                        wire:target="uploadQuiz"
                        class="py-2.5 px-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition inline-flex items-center">
                        <span wire:loading.remove wire:target="uploadQuiz">Upload Quiz</span>
                        <span wire:loading wire:target="uploadQuiz">Uploading...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif


    <ol class="relative border-s border-gray-200 dark:border-gray-700">
    @php
        use Carbon\Carbon;

        $quizzesByDate = $quizzes->sortBy('start_date')->groupBy(fn($quiz) => Carbon::parse($quiz->start_date)->format('Y-m-d'));
        $today = Carbon::now()->format('Y-m-d');
    @endphp

    @foreach ($quizzesByDate as $date => $quizzesForDate)
        @php
            $isToday = $date == $today;
            $isPast = $date < $today;
            $isFuture = $date > $today;

            // Indicator and Line Color
            $indicatorColor = $isToday ? 'bg-green-500' : ($isPast ? 'bg-blue-500' : 'bg-gray-400');
            $textColor = $isToday ? 'text-green-600' : ($isPast ? 'text-blue-600' : 'text-gray-500');
            $statusText = $isToday ? 'In Progress' : ($isPast ? 'Completed' : 'Upcoming');
        @endphp

        <li class="mb-10 ms-4">
            <!-- Date Indicator -->
            <div class="absolute w-3 h-3 {{ $indicatorColor }} rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900"></div>
            
            <!-- Date and Status -->
            <time class="mb-1 text-sm font-normal leading-none {{ $textColor }}">{{ Carbon::parse($date)->format('F j, Y') }}</time>
            <span class="text-sm {{ $textColor }}">({{ $statusText }})</span>

            <!-- Quizzes for the Date -->
            @foreach ($quizzesForDate->sortBy('start_date') as $quiz)
                <div class="flex justify-between items-center p-6 bg-gray-100 rounded-lg shadow-md hover:bg-gray-200 transition w-full mb-4">
                    <!-- Quiz Details -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $quiz->quiz_name }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Subject: {{ $quiz->subject->name }}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Start Time: {{ Carbon::parse($quiz->start_date)->format('h:i A') }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Duration: {{ $quiz->duration }} mins</p>
                    </div>

                    <!-- Actions on the Right -->
                    <div class="flex flex-col space-y-2">
                        <!-- View Button -->
                        <a href="{{ route('quiz.view', ['id' => $quiz->quiz_id]) }}"
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 focus:text-blue-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        View
                    </a>
                    <button wire:click="confirmDelete({{ $quiz->quiz_id }})"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 hover:text-red-700 focus:z-10 focus:ring-4 focus:outline-none focus:ring-gray-100 focus:text-red-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                        Delete
                    </button>
                    </div>
                </div>
            @endforeach
        </li>
    @endforeach
</ol>
















    <!-- All Quizzes (Upcoming & Past) Sorted by Subject -->
    <div>

                                            <!-- Delete Confirmation Modal -->
                @if ($confirmDeleteModal)
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-20 flex justify-center items-center">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h2 class="text-lg font-semibold mb-4">Confirm Delete</h2>
                            <p class="text-gray-700 mb-3">Are you sure you want to delete this quiz? This action cannot be undone.</p>

                            <!-- Password Input -->
                            <label for="password" class="text-sm font-medium text-gray-600">Enter Password:</label>
                            <input type="password" wire:model="password"
                                class="border border-gray-300 rounded-md w-full p-2 mt-1 focus:outline-none focus:ring-2 focus:ring-blue-400">

                            @if (session()->has('error'))
                                <p class="text-red-500 text-sm mt-2">{{ session('error') }}</p>
                            @endif

                            <div class="flex justify-end mt-4">
                                <button wire:click="$set('confirmDeleteModal', false)"
                                    class="mr-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                    Cancel
                                </button>
                                <button wire:click="deleteQuiz"
                                    wire:loading.attr="disabled" 
                                    wire:target="deleteQuiz"
                                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700">
                                    <span wire:loading.remove wire:target="deleteQuiz">Confirm</span>
                                    <span wire:loading wire:target="deleteQuiz">Deleting...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif

    </div>


</section>
