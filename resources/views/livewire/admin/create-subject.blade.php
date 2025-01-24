<div>
    <!-- Header Section -->
    <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-slate-900">Subjects</h2>
            <!-- Button to Open Modal -->
            <button 
                class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium px-4 py-2 shadow-sm"
                wire:click="openModal">
                <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                    <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                </svg>
                New Subject
            </button>
        </div>
    </header>

    <!-- Subject Cards -->
    <ul class="bg-slate-50 p-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm leading-6">
        @foreach ($subjects as $subject)
        <li>
            <div class="hover:bg-blue-500 hover:ring-blue-500 hover:shadow-md group rounded-md p-3 bg-white ring-1 ring-slate-200 shadow-sm">
                <dl class="grid grid-cols-2 items-center">
                    <div>
                        <dt class="sr-only">Name</dt>
                        <dd class="group-hover:text-white font-semibold text-slate-900">
                            {{ $subject->name }}
                        </dd>
                    </div>
                    <div>
                        <dt class="sr-only">Description</dt>
                        <dd class="group-hover:text-blue-200">{{ $subject->description }}</dd>
                    </div>
                    <div class="col-span-2 mt-2">
                        <dt class="sr-only">Assigned Instructors</dt>
                        <dd class="text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Assigned to:</span>
                            @if ($subject->instructors->isEmpty())
                                <span class="text-gray-500">No instructors assigned</span>
                            @else
                                @foreach ($subject->instructors as $instructor)
                                    @php
                                        $nameParts = explode(' ', $instructor->name);
                                        $firstInitial = strtoupper(substr($nameParts[0], 0, 1));
                                        $lastInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '';
                                    @endphp
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full mr-1">
                                        {{ $firstInitial . $lastInitial }}
                                    </span>
                                @endforeach
                            @endif
                        </dd>
                    </div>
                    <div class="col-span-2 mt-2 flex justify-end space-x-2">
                        <!-- Assign Button -->
                        <button 
                            class="text-sm text-blue-600 hover:underline" 
                            wire:click="openAssignModal({{ $subject->id }})">
                            Assign
                        </button>
                        <!-- Delete Button -->
                        <button 
                            class="text-sm text-red-600 hover:underline" 
                            wire:click="delete({{ $subject->id }})">
                            Delete
                        </button>
                    </div>
                </dl>
            </div>
        </li>
        @endforeach
        <li class="flex">
            <button 
                wire:click="openModal"
                wire:target="openModal"
                wire:loading.attr="disabled"
                class="hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group w-full flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3 relative">
                <!-- Default Plus Icon -->
                <svg 
                    wire:loading.remove 
                    wire:target="openModal"
                    class="group-hover:text-blue-500 mb-1 text-slate-400 transition-transform"
                    width="20" 
                    height="20" 
                    fill="currentColor" 
                    aria-hidden="true">
                    <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                </svg>

                <!-- Spinning Loader -->
                <svg 
                    wire:loading 
                    wire:target="openModal"
                    class="animate-spin text-blue-500 mb-1"
                    xmlns="http://www.w3.org/2000/svg"
                    width="20" 
                    height="20" 
                    fill="none" 
                    viewBox="0 0 24 24">
                    <circle 
                        class="opacity-25" 
                        cx="12" 
                        cy="12" 
                        r="10" 
                        stroke="currentColor" 
                        stroke-width="4">
                    </circle>
                    <path 
                        class="opacity-75" 
                        fill="currentColor" 
                        d="M4 12a8 8 0 018-8v8H4z">
                    </path>
                </svg>

                New Subject
            </button>
        </li>

    </ul>

    <!-- Modal for Creating a Subject -->
    @if($showModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Create New Subject</h3>
            <form wire:submit.prevent="submit">
                <!-- Name Input -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        id="name" 
                        type="text" 
                        wire:model="name"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <!-- Description Input -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea 
                        id="description" 
                        wire:model="description"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <!-- Actions -->
                <div class="flex justify-end space-x-2">
                    <!-- Cancel Button -->
                    <button 
                        type="button" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-md"
                        wire:click="closeModal"
                        wire:loading.attr="disabled"
                        wire:target="closeModal">
                        Cancel
                    </button>

                    <!-- Save Button -->
                    <button 
                        type="submit" 
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md flex items-center justify-center"
                        wire:target="submit"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="submit">Save</span>
                        <svg 
                            wire:loading wire:target="submit" 
                            class="animate-spin h-5 w-5 text-white ml-2" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24">
                            <circle 
                                class="opacity-25" 
                                cx="12" 
                                cy="12" 
                                r="10" 
                                stroke="currentColor" 
                                stroke-width="4">
                            </circle>
                            <path 
                                class="opacity-75" 
                                fill="currentColor" 
                                d="M4 12a8 8 0 018-8v8H4z">
                            </path>
                        </svg>
                    </button>
                </div>

            </form>
        </div>
    </div>
    @endif

    <!-- Modal for Assigning Instructors -->
    @if($showAssignModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Assign Subject</h3>
            <form wire:submit.prevent="assign">
                <!-- Dropdown for Instructors -->
                <div class="mb-4">
                    <label for="instructor" class="block text-sm font-medium text-gray-700">Select Instructor</label>
                    <select 
                        wire:model="selectedInstructorId" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        <option value="">Select an Instructor</option>
                        @foreach ($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                    @error('selectedInstructorId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <!-- Actions -->
                <div class="flex justify-end space-x-2">
                    <button 
                        type="button" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-md"
                        wire:click="closeAssignModal">
                        Cancel
                    </button>
                    <button 
                        type="submit"
                        wire:target="assign"
                        wire:loading.attr="disabled"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md flex items-center justify-center">
                        <span wire:loading.remove wire:target="assign">Assign</span>
                        <span wire:loading wire:target="assign" class="flex items-center">
                            <svg class="animate-spin h-5 w-5 text-white mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Loading...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
