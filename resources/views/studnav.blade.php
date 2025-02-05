
<!-- nav.blade.php -->
<nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700" >
  <div class="px-3 py-3 lg:px-5 lg:pl-3">
    <div class="flex items-center justify-between">
      <!-- Sidebar button and logo -->
      <div class="flex items-center justify-start rtl:justify-end">
      <!-- Button to toggle sidebar -->
      <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
            <span class="sr-only">Open sidebar</span>
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
               <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
            </svg>
         </button>
         <a href="https://your-website.com" class="flex ms-2 md:me-24">
            <!-- Updated the path to reference public/images -->
            <img src="{{ asset('images/wc_logo_497x265.png') }}" class="h-8 me-3" alt="Your Logo" />
        </a>
      </div>




      <!-- User Profile and Dropdown -->
      <div class="flex items-center">
        <div class="flex items-center ms-3">
          <div class="flex items-center gap-4">
            <button @click="open = !open" class="flex items-center text-sm text-gray-900 dark:text-white">
              <div class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                <span class="font-medium text-gray-600 dark:text-gray-300">
                  @php
                    $nameParts = explode(' ', auth()->user()->name);
                    $firstInitial = strtoupper(substr($nameParts[0], 0, 1));
                    $lastInitial = isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) : '';
                    echo $firstInitial . $lastInitial;
                  @endphp
                </span>
              </div>
            </button>
            <div class="font-medium dark:text-white">
              <span class="text-black-500 mr-4">{{ auth()->user()->name }}</span>
              <div class="text-sm text-gray-500 dark:text-gray-400">
                Joined in {{ auth()->user()->created_at->format('F Y') }}
              </div>
            </div>
          </div>

          <!-- Dropdown Button -->
          <div x-data="{ open: false }" class="relative">
            <!-- Button that triggers the dropdown -->
            <button @click="open = !open" class="text-gray-900 dark:text-white">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>

            <!-- Dropdown menu -->
            <div x-show="open" @click.away="open = false" class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2 w-48">
              <div class="px-4 py-3">
                <p class="text-sm text-gray-900 dark:text-white">
                  {{ auth()->user()->name }}
                </p>
                <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300">
                  {{ auth()->user()->email }}
                </p>
              </div>
              <ul class="py-1">
                <li>
                  <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>


<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
   <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
      <ul class="space-y-2 font-medium">
         
         <!-- 📊 Dashboard -->
         <li>
            <a wire:navigate href="{{ route('student.dashboard') }}" 
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
               {{ request()->routeIs('student.dashboard') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('student.dashboard') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" 
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
               </svg>
               <span class="ms-3">Dashboard</span>
            </a>
         </li>

         <!-- 📚 Subjects -->
         <li>
            <a wire:navigate href="{{ route('student.enrolledSubjects') }}" 
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
               {{ request()->routeIs('student.enrolledSubjects') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('student.enrolledSubjects') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" 
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
               </svg>
               <span class="ms-3">Subjects</span>
            </a>
         </li>

         <!-- 📝 Quizzes -->
         <li>
            <a wire:navigate href="{{ route('student.quizzes') }}" 
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
               {{ request()->routeIs('student.quizzes') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('student.quizzes') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" 
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
               </svg>
               <span class="ms-3">Quizzes</span>
            </a>
         </li>

         <!-- 🏆 Results -->
         <li>
            <a wire:navigate href="{{ route('student.results') }}" 
               class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
               {{ request()->routeIs('student.results') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
               <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('student.results') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}" 
                  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
               </svg>
               <span class="ms-3">Results</span>
            </a>
         </li>

      </ul>
   </div>
</aside>

