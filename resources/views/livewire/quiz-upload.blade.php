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
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <form wire:submit.prevent="uploadQuiz" enctype="multipart/form-data" class="space-y-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Upload New Quiz</h3>
                        <div>
                            <label for="quizName" class="block font-semibold mb-2">Quiz Name</label>
                            <input type="text" id="quizName" wire:model="quizName" placeholder="Enter the quiz name" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('quizName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="quizDuration" class="block font-semibold mb-2">Duration (in minutes)</label>
                            <input type="number" id="quizDuration" wire:model="quizDuration" placeholder="Enter duration (e.g., 30)" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('quizDuration') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="quizSet" class="block font-semibold mb-2">Quiz Set</label>
                            <input type="text" id="quizSet" wire:model="quizSet" placeholder="Enter the quiz set (e.g., November Quiz 1)" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('quizSet') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="csvFile" class="block font-semibold mb-2">Upload Quiz CSV</label>
                            <input type="file" id="csvFile" wire:model="csvFile" accept=".csv" class="border rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500 focus:outline-none">
                            @error('csvFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end">
                        <button 
                            type="button" 
                            wire:click="$set('showModal', false)" 
                            class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400 focus:outline-none mr-2"
                            wire:loading.attr="disabled" 
                            wire:target="$set('showModal', false)"
                        >
                            <span wire:loading.remove wire:target="$set('showModal', false)">Cancel</span>
                            <span wire:loading wire:target="$set('showModal', false)">
                                <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 11-8 8z"></path>
                                </svg>
                                Closing...
                            </span>
                        </button>
                            <button 
                                type="submit" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                                wire:loading.attr="disabled" 
                                wire:target="uploadQuiz"
                            >
                                <span wire:loading.remove wire:target="uploadQuiz">Upload Quiz</span>
                                <span wire:loading wire:target="uploadQuiz">
                                    <svg class="animate-spin h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 11-8 8z"></path>
                                    </svg>
                                    Uploading...
                                </span>
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <ul class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($quizzes as $quiz)
            <li>
                <a href="{{ route('quiz.view', ['id' => $quiz->quiz_id]) }}" class="hover:bg-light-blue-500 group block rounded-lg p-4 border">
                    <dl class="grid sm:block lg:grid xl:block grid-cols-2 grid-rows-2 items-center">
                        <div>
                            <dd class="group-hover:text-white leading-6 font-medium text-black">
                                {{ $quiz->quiz_name }}
                            </dd>
                        </div>
                        <div>
                            <dd class="group-hover:text-light-blue-200 text-sm font-medium">
                                Duration: {{ $quiz->duration }} mins
                            </dd>
                        </div>
                        <div class="col-start-2 row-start-1 row-end-3">
                            <dd class="text-gray-600 text-sm">
                                Last Updated: {{ $quiz->updated_at->format('F j, Y') }}
                            </dd>
                        </div>
                    </dl>
                </a>
            </li>
        @endforeach

        <li class="hover:shadow-lg flex rounded-lg">
            <button 
                wire:click="$set('showModal', true)" 
                class="hover:border-transparent hover:shadow-xs w-full flex items-center justify-center rounded-lg border-2 border-dashed border-gray-200 text-sm font-medium py-4"
                wire:loading.attr="disabled" 
                wire:target="$set('showModal', true)"
            >
                <span wire:loading.remove wire:target="$set('showModal', true)">
                    <svg class="mr-2 text-light-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    New Quiz
                </span>
                <span wire:loading wire:target="$set('showModal', true)">
                    <svg class="animate-spin h-5 w-5 text-light-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 11-8 8z"></path>
                    </svg>
                    Opening...
                </span>
            </button>
        </li>

    </ul>
</section>
