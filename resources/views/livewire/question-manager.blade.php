<div class="container mx-auto py-16 px-8 sm:px-10 lg:px-20 bg-gradient-to-r from-blue-50 to-indigo-100 min-h-screen">
    <h1 class="text-5xl font-extrabold text-center text-indigo-800 mb-14">Manage Questions Easily</h1>

    <!-- Form Section -->
    <div class="bg-white rounded-xl shadow-2xl p-12">
        <form wire:submit.prevent="generateQuestions">
            <div class="space-y-8">
                <!-- Topic Field -->
                <div>
                    <label for="topic" class="block text-lg font-semibold text-gray-700 mb-2">Topic</label>
                    <input type="text" id="topic" wire:model="topic" placeholder="Enter the topic"
                        class="w-full border border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-4">
                    @error('topic') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <!-- Difficulty Dropdown -->
                    <div>
                        <label for="difficulty" class="block text-lg font-semibold text-gray-700 mb-2">Difficulty</label>
                        <select id="difficulty" wire:model="difficulty"
                            class="w-full border border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-4">
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                        @error('difficulty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Number of Questions -->
                    <div>
                        <label for="numberOfQuestions" class="block text-lg font-semibold text-gray-700 mb-2">Number of Questions</label>
                        <input type="number" id="numberOfQuestions" wire:model="numberOfQuestions" min="1" max="50"
                            class="w-full border border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-4">
                        @error('numberOfQuestions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Question Type Dropdown -->
                <div>
                    <label for="questionType" class="block text-lg font-semibold text-gray-700 mb-2">Question Type</label>
                    <select id="questionType" wire:model="questionType"
                        class="w-full border border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-4">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                    </select>
                    @error('questionType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-12 flex justify-center">
                <button type="submit" wire:loading.attr="disabled"
                    class="bg-indigo-600 text-white px-12 py-4 rounded-full shadow-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-400 transition-transform transform hover:scale-105"
                    wire:loading.remove>
                    Generate Questions
                </button>

                <!-- Spinner -->
                <div role="status" wire:loading>
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </form>
    </div>

    <!-- Flash Messages Section -->
    <div class="mt-12">
        @if (session()->has('success'))
            <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
                <svg class="w-5 h-5 text-green-600 dark:text-green-500 rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"/>
                </svg>
                <div class="ps-4 text-sm font-normal">{{ session('success') }}</div>
            </div>
        @endif
        @if (session()->has('error'))
            <div id="toast-simple" class="flex items-center w-full max-w-xs p-4 space-x-4 rtl:space-x-reverse text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800" role="alert">
                <svg class="w-5 h-5 text-red-600 dark:text-red-500 rotate-45" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 17 8 2L9 1 1 19l8-2Zm0 0V9"/>
                </svg>
                <div class="ps-4 text-sm font-normal">{{ session('error') }}</div>
            </div>
        @endif
    </div>

    <div class="bg-gray-100 p-4 rounded-lg mt-8">
        <h2 class="text-lg font-bold text-gray-700">Debug Information</h2>
        
        <!-- Display Prompt -->
        <div class="mt-4">
            <h3 class="text-md font-semibold text-gray-600">Generated Prompt</h3>
            <pre class="text-sm bg-gray-50 p-4 rounded-lg border border-gray-300 overflow-auto">{{ $this->buildPrompt() }}</pre>
        </div>
        
        <!-- Display ChatGPT Response -->
        <div class="mt-4">
            <h3 class="text-md font-semibold text-gray-600">ChatGPT Response</h3>
            <pre class="text-sm bg-gray-50 p-4 rounded-lg border border-gray-300 overflow-auto">{{ $chatgptResponse }}</pre>
        </div>
    </div>

    <!-- Displaying Questions -->
    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 mt-14">
        @foreach ($this->paginatedQuestions as $pageIndex => $question)
            <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200">
                @if ($editing === ($pageIndex + ($page - 1) * $perPage))
                    <div>
                        <label class="block text-base font-semibold text-gray-700 mb-3">Question</label>
                        <input type="text" wire:model="questions.{{ $pageIndex + ($page - 1) * $perPage }}.question"
                            class="w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-3">
                        @error('questions.' . ($pageIndex + ($page - 1) * $perPage) . '.question') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror

                        <!-- Options for Multiple Choice or True/False -->
                        <div class="mt-6">
                            <label class="block text-base font-semibold text-gray-700 mb-3">Options</label>
                            @if ($question['options'])
                                @foreach ($question['options'] as $optionIndex => $option)
                                    <div class="flex items-center mt-4">
                                        <!-- For Multiple Choice, Use Radio Buttons -->
                                        <input type="radio" wire:model="questions.{{ $pageIndex + ($page - 1) * $perPage }}.answer" 
                                            name="answer_{{ $pageIndex + ($page - 1) * $perPage }}" value="{{ $optionIndex }}" class="mr-3">
                                        <input type="text" wire:model="questions.{{ $pageIndex + ($page - 1) * $perPage }}.options.{{ $optionIndex }}"
                                            class="w-full border-gray-300 rounded-lg shadow-md focus:ring-indigo-600 focus:border-indigo-600 px-5 py-3">
                                    </div>
                                    @error('questions.' . ($pageIndex + ($page - 1) * $perPage) . '.options.' . $optionIndex) 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                @endforeach
                            @else
                                <!-- For True/False Questions -->
                                <div class="flex items-center mt-4">
                                    <input type="radio" wire:model="questions.{{ $pageIndex + ($page - 1) * $perPage }}.answer" 
                                        name="answer_{{ $pageIndex + ($page - 1) * $perPage }}" value="0" class="mr-3">
                                    <span>True</span>
                                </div>
                                <div class="flex items-center mt-4">
                                    <input type="radio" wire:model="questions.{{ $pageIndex + ($page - 1) * $perPage }}.answer" 
                                        name="answer_{{ $pageIndex + ($page - 1) * $perPage }}" value="1" class="mr-3">
                                    <span>False</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-8 flex space-x-6">
                            <button wire:click="saveQuestion({{ $pageIndex + ($page - 1) * $perPage }})" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-700">
                                Save
                            </button>
                            <button wire:click="cancelEdit" class="bg-gray-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>
                @else
                    <h3 class="text-lg font-bold text-gray-900">{{ $question['question'] ?? 'Undefined Question' }}</h3>
                    <ul class="mt-6 space-y-3">
                        @foreach ($question['options'] ?? [] as $optionIndex => $option)
                            <li class="text-gray-800">
                                <span class="font-semibold">{{ chr(65 + $optionIndex) }}.</span> {{ $option }}
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-6 text-sm text-green-600">
                        <strong>Correct Answer:</strong> {{ $question['options'][$question['answer']] ?? 'None' }}
                    </div>

                    <button wire:click="editQuestion({{ $pageIndex }})"
                        class="mt-6 bg-indigo-500 text-white px-8 py-3 rounded-lg shadow-md hover:bg-indigo-600">
                        Edit
                    </button>
                                    <!-- Add Delete Button -->
                <button wire:click="deleteQuestion({{ $pageIndex + ($page - 1) * $perPage }})"
                    class="mt-6 bg-red-600 text-white px-8 py-3 rounded-lg shadow-md hover:bg-red-700">
                    Delete
                </button>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination Section -->
    <div class="mt-16 flex justify-center space-x-8">
        <button wire:click="previousPage" class="px-8 py-4 bg-gray-600 text-white rounded-full shadow-md hover:bg-gray-700 disabled:opacity-50" {{ $page === 1 ? 'disabled' : '' }}>
            Previous
        </button>
        <button wire:click="nextPage" class="px-8 py-4 bg-gray-600 text-white rounded-full shadow-md hover:bg-gray-700 disabled:opacity-50" {{ $page * $perPage >= count($questions) ? 'disabled' : '' }}>
            Next
        </button>
    </div>

</div>
