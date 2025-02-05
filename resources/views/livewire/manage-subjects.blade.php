<section>
  <header class="bg-white space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-slate-900">Manage Subjects</h2>
      <!-- Disabled New Subject Button -->
      <button class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm" disabled>
        <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
          <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
        </svg>
        New Subject (Coming Soon)
      </button>
    </div>
    <!-- Search Subjects -->
    <form class="group relative">
      <svg width="20" height="20" fill="currentColor" class="absolute left-3 top-1/2 -mt-2.5 text-slate-400 pointer-events-none group-focus-within:text-blue-500" aria-hidden="true">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
      </svg>
      <input class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm" type="text" wire:model="searchTerm" placeholder="Filter subjects...">
    </form>
  </header>

  <!-- Subjects List -->
  <ul class="bg-slate-50 p-4 sm:px-8 sm:pt-6 sm:pb-8 lg:p-4 xl:px-8 xl:pt-6 xl:pb-8 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm leading-6">
    @forelse ($subjects as $subject)
      <li>
        <div class="bg-white shadow-md rounded-lg p-4 border border-gray-200">
          <h3 class="font-semibold text-lg text-slate-900">{{ $subject->name }}</h3>
          <p class="text-sm text-gray-600">{{ $subject->description }}</p>

          <div class="mt-4">
            <h4 class="font-medium text-slate-900">Enrolled Students:</h4>
            @if ($subject->students->isEmpty())
              <p class="text-gray-500">No students enrolled</p>
            @else
              <ul class="mt-2 space-y-2">
                @foreach ($subject->students as $student)
                  <li class="flex items-center justify-between">
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                      {{ $student->name }}
                    </span>
                    @if ($selectedSubject && $selectedSubject->id === $subject->id)
                      <button 
                        class="text-sm text-red-600 hover:underline" 
                        wire:click="removeStudent({{ $student->id }})" 
                        wire:loading.attr="disabled" 
                        wire:target="removeStudent({{ $student->id }})">
                        Remove
                      </button>
                    @endif
                  </li>
                @endforeach
              </ul>
            @endif
          </div>

          <div class="mt-4">
            <button 
              class="text-blue-600 text-sm hover:underline" 
              wire:click="selectSubject({{ $subject->id }})" 
              wire:loading.attr="disabled" 
              wire:target="selectSubject({{ $subject->id }})">
              Enroll Students
            </button>
            <span wire:loading wire:target="selectSubject({{ $subject->id }})" class="text-blue-500 text-sm">Loading...</span>
          </div>
        </div>
      </li>
    @empty
      <li class="text-gray-500">No subjects found.</li>
    @endforelse
  </ul>

  <!-- Enroll Students Section -->
  @if ($selectedSubject)
    <section class="bg-white shadow-md rounded-lg p-4 mt-6">
      <h3 class="text-lg font-semibold text-slate-900">Enroll Students for {{ $selectedSubject->name }}</h3>
      <form wire:submit.prevent="enrollStudents" class="mt-4">
        <label for="students" class="block text-sm font-medium text-gray-700">Select Students</label>
        <select id="students" wire:model="selectedStudents" multiple class="mt-2 w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
          @foreach ($students as $student)
            <option value="{{ $student->id }}">{{ $student->name }}</option>
          @endforeach
        </select>
        <div class="flex items-center space-x-2">
          <button type="submit" class="mt-3 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
                  wire:loading.attr="disabled" 
                  wire:target="enrollStudents">
            Enroll Selected Students
          </button>
          <span wire:loading wire:target="enrollStudents" class="text-blue-500 text-sm">Enrolling...</span>
        </div>
      </form>
    </section>
  @endif
</section>
