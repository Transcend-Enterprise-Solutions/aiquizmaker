<div class="container mx-auto py-12 px-6 sm:px-8 lg:px-16">
    <h1 class="text-5xl font-extrabold text-center text-indigo-700 mb-16">Question Manager</h1>

    <!-- Form to generate questions -->
    <div class="relative">
        <form wire:submit.prevent="generateQuestions" class="bg-gradient-to-br from-white to-gray-50 rounded-xl p-8 shadow-xl border border-gray-300">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="col-span-2">
                    <label for="topic" class="block mb-2 text-sm font-medium text-gray-900">Topic</label>
                    <input type="text" id="topic" wire:model="topic" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" placeholder="Enter topic" required>
                    @error('topic') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="difficulty" class="block text-base font-medium text-gray-700">Difficulty</label>
                    <select id="difficulty" wire:model="difficulty" 
                        class="mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                    @error('difficulty') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="numberOfQuestions" class="block text-base font-medium text-gray-700">Number of Questions</label>
                    <input type="number" id="numberOfQuestions" wire:model="numberOfQuestions" min="1" max="50" 
                        class="mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('numberOfQuestions') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="questionType" class="block text-base font-medium text-gray-700">Question Type</label>
                    <select id="questionType" wire:model="questionType" 
                        class="mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="true_false">True/False</option>
                    </select>
                    @error('questionType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mt-10 flex justify-center">
                <button type="submit" wire:loading.attr="disabled" 
                    class="bg-indigo-600 text-white py-3 px-8 rounded-lg shadow-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-400">
                    Generate Questions
                </button>
            </div>
        </form>

        <!-- Loading Spinner -->
        <div wire:loading class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 rounded-xl z-20">
            <div class="flex flex-col items-center">
                <svg aria-hidden="true" class="w-12 h-12 text-gray-200 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 100 101">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="text-white text-sm mt-2">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="mt-12 space-y-4">
        @if (session()->has('success'))
            <div class="p-4 bg-green-100 border border-green-200 text-green-800 rounded-lg">
                <strong>{{ session('success') }}</strong>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="p-4 bg-red-100 border border-red-200 text-red-800 rounded-lg">
                <strong>{{ session('error') }}</strong>
            </div>
        @endif
    </div>

    <!-- Questions List -->
    <div class="mt-16 grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($this->paginatedQuestions as $index => $question)
            <div class="bg-white p-6 rounded-xl shadow-md border border-gray-300">
                @if ($editing === $index)
                    <!-- Edit Mode -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Question</label>
                        <input type="text" wire:model="questions.{{ $index }}.question" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                        @error('questions.' . $index . '.question') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Options</label>
                        @foreach ($question['options'] as $optionIndex => $option)
                            <input type="text" wire:model="questions.{{ $index }}.options.{{ $optionIndex }}" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Option {{ chr(65 + $optionIndex) }}"/>
                            @error('questions.' . $index . '.options.' . $optionIndex) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Answer</label>
                        <input type="text" wire:model="questions.{{ $index }}.answer" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"/>
                        @error('questions.' . $index . '.answer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex space-x-4">
                        <button wire:click="saveQuestion({{ $index }})" class="bg-green-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-green-700 focus:ring-4 focus:ring-green-400">
                            Save
                        </button>
                        <button wire:click="cancelEdit" class="bg-gray-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-gray-700 focus:ring-4 focus:ring-gray-400">
                            Cancel
                        </button>
                    </div>
                @else
                    <!-- View Mode -->
                    <h3 class="text-lg font-bold text-gray-800">{{ $loop->iteration + (($page - 1) * $perPage) }}. {{ $question['question'] }}</h3>
                    <ul class="mt-3 space-y-2">
                        @foreach ($question['options'] as $optionIndex => $option)
                            <li class="text-gray-700"><span class="font-bold">{{ chr(65 + $optionIndex) }}.</span> {{ $option }}</li>
                        @endforeach
                    </ul>
                    <p class="mt-4 text-sm text-gray-600"><strong>Answer:</strong> {{ $question['answer'] }}</p>

                    <button wire:click="editQuestion({{ $index }})" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-400">
                        Edit
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex flex-col items-center mt-8">
        <!-- Help text -->
        <span class="text-sm text-gray-700 dark:text-gray-400">
            Showing 
            <span class="font-semibold text-gray-900 dark:text-white">{{ ($page - 1) * $perPage + 1 }}</span> 
            to 
            <span class="font-semibold text-gray-900 dark:text-white">{{ min($page * $perPage, count($questions)) }}</span> 
            of 
            <span class="font-semibold text-gray-900 dark:text-white">{{ count($questions) }}</span> 
            Entries
        </span>

        <div class="inline-flex mt-2 xs:mt-0">
            <!-- Previous Button -->
            <button 
                wire:click="previousPage" 
                class="flex items-center justify-center px-4 h-10 text-base font-medium text-white bg-gray-800 rounded-s hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                {{ $page === 1 ? 'disabled' : '' }}
            >
                <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                </svg>
                Prev
            </button>

            <!-- Next Button -->
            <button 
                wire:click="nextPage" 
                class="flex items-center justify-center px-4 h-10 text-base font-medium text-white bg-gray-800 border-0 border-s border-gray-700 rounded-e hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                {{ $page * $perPage >= count($questions) ? 'disabled' : '' }}
            >
                Next
                <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                </svg>
            </button>
        </div>
    </div>
</div>
