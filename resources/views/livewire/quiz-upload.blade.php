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
<div class="fixed z-10 inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full sm:max-w-lg">
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
                <button 
                    type="submit" 
                    wire:click="uploadQuiz" 
                    wire:loading.attr="disabled" 
                    wire:target="uploadQuiz" 
                    class="py-2.5 px-5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 focus:outline-none transition inline-flex items-center">
                    <!-- Spinner (Visible During Loading) -->
                    <svg 
                        wire:loading 
                        wire:target="uploadQuiz" 
                        aria-hidden="true" 
                        role="status" 
                        class="inline w-4 h-4 mr-3 text-blue-200 animate-spin" 
                        viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="white"/>
                    </svg>

                    <!-- Button Text -->
                    <span wire:loading.remove wire:target="uploadQuiz">Upload Quiz</span>
                    <span wire:loading wire:target="uploadQuiz">Uploading...</span>
                </button>
            </div>




            </div>
        </form>
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
                        <div>
                            <dd class="text-gray-600 text-sm">
                                Start: {{ $quiz->start_date }}
                            </dd>
                        </div>
                        <div>
                            <dd class="text-gray-600 text-sm">
                                End: {{ $quiz->end_date }}
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
            >
                <svg class="mr-2 text-light-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="20" height="20">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Quiz
            </button>
        </li>
    </ul>
</section>
