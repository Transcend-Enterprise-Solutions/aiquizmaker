<!-- nav.blade.php -->
<div x-data="{ sidebarOpen: true }">
    <nav class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <!-- Sidebar button and logo -->
                <div class="flex items-center justify-start rtl:justify-end">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                        <span class="sr-only">Toggle sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
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
                            <button @click="open = !open"
                                class="flex items-center text-sm text-gray-900 dark:text-white">
                                <div
                                    class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600">
                                    <span class="font-medium text-gray-600 dark:text-gray-300">
                                        @php
                                            $nameParts = explode(' ', auth()->user()->name);
                                            $firstInitial = strtoupper(substr($nameParts[0], 0, 1));
                                            $lastInitial = isset($nameParts[1])
                                                ? strtoupper(substr($nameParts[1], 0, 1))
                                                : '';
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
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>

                            <!-- Dropdown menu -->
                            <div x-show="open" @click.away="open = false"
                                class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 absolute right-0 mt-2 w-48">
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
                                        <a href="{{ route('logout') }}"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign
                                            out</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="hidden">
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


    <aside id="logo-sidebar" x-cloak :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }"
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">
        <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
            <ul class="space-y-2 font-medium">
                <li>
                    <a wire:navigate href="{{ route('instructor.welcome') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
            {{ request()->routeIs('instructor.welcome') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 
                {{ request()->routeIs('instructor.welcome') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('instructor.quiz') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
            {{ request()->routeIs('instructor.quiz') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 
                {{ request()->routeIs('instructor.quiz') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3V6zm0 5h12v2H3v-2zm0 5h18v2H3v-2z" />
                        </svg>
                        <span class="ms-3">Quiz Generator</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('instructor.upload') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
            {{ request()->routeIs('instructor.upload') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 
                {{ request()->routeIs('instructor.upload') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M14 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8l-6-6zM13 9V3.5L18.5 9H13z" />
                        </svg>
                        <span class="ms-3">Manage Quiz</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('instructor.enroll') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
            {{ request()->routeIs('instructor.enroll') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 
                {{ request()->routeIs('instructor.enroll') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V20h14v-3.5c0-2.33-4.67-3.5-7-3.5zM6 11c1.66 0 3-1.34 3-3S7.66 5 6 5 3 6.34 3 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V20h7v-3.5c0-2.33 4.67-3.5 7-3.5H6z" />
                        </svg>
                        <span class="ms-3">Enroll a Student</span>
                    </a>
                </li>
                <li>
                    <a wire:navigate href="{{ route('instructor.subjects') }}"
                        class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group
              {{ request()->routeIs('instructor.subjects') ? 'bg-gray-200 dark:bg-gray-800 text-indigo-600' : '' }}">
                        <svg class="w-5 h-5 transition duration-75 
                  {{ request()->routeIs('instructor.subjects') ? 'text-indigo-600' : 'text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white' }}"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4 6v12h16V6H4zm2 10V8h12v8H6zm4-7h4v2h-4v-2zm0 4h4v2h-4v-2z" />
                        </svg>
                        <span class="ms-3">Subjects</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <div x-show="sidebarOpen" @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden">
    </div>
</div>
