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
                            <div class="flex items-center mt-2">
                                <input type="radio" wire:model="questions.{{ $index }}.answer" value="{{ $optionIndex }}" class="mr-2">
                                <input type="text" wire:model="questions.{{ $index }}.options.{{ $optionIndex }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Option {{ chr(65 + $optionIndex) }}"/>
                            </div>
                            @error('questions.' . $index . '.options.' . $optionIndex) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        @endforeach
                    </div>

                    <!-- Display selected answer text -->
                    <div class="mt-4 text-sm text-gray-700">
                        <strong>Selected Answer:</strong> {{ $question['options'][$question['answer']] ?? 'None' }}
                    </div>

                    <div class="flex space-x-4 mt-4">
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
                            <li class="text-gray-700">
                                <span class="font-bold">{{ chr(65 + $optionIndex) }}.</span>
                                {{ $option }} 
                                @if ($question['answer'] === $optionIndex)
                                    <span class="text-green-600 font-semibold">(Correct)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 text-sm text-gray-700">
                        <strong>Correct Answer:</strong> {{ $question['options'][$question['answer']] ?? 'None' }}
                    </div>
                    <button wire:click="editQuestion({{ $index }})" class="mt-4 bg-blue-600 text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-700 focus:ring-4 focus:ring-blue-400">
                        Edit
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-8">
        <button wire:click="previousPage" class="px-4 py-2 mx-1 bg-gray-800 text-white rounded-lg disabled:opacity-50" {{ $page === 1 ? 'disabled' : '' }}>
            Previous
        </button>
        <button wire:click="nextPage" class="px-4 py-2 mx-1 bg-gray-800 text-white rounded-lg disabled:opacity-50" {{ $page * $perPage >= count($questions) ? 'disabled' : '' }}>
            Next
        </button>
    </div>
</div>
