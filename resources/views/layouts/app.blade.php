<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' || window.matchMedia('(prefers-color-scheme: dark)').matches }" x-init="$watch('darkMode', value => localStorage.setItem('darkMode', value))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gray-800 dark:bg-gray-900 text-white shadow py-4">
            <div class="container mx-auto flex justify-between items-center">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-400 dark:text-blue-500">Laravel</a>
                <div class="flex items-center space-x-4">

                <!-- Navigation if student or instructor -->
                @if (auth()->check())
                    @if (auth()->user()->role === 'student')
                        <a href="{{ route('student.dashboard') }}" class="hover:underline">Student Dashboard</a>
                    @elseif (auth()->user()->role === 'instructor')
                        <a href="{{ route('instructor.dashboard') }}" class="hover:underline">Instructor Dashboard</a>
                    @endif
                @endif


                    @auth
                        <span>{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="hover:underline">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="hover:underline">Login</a>
                        <a href="{{ route('register') }}" class="hover:underline">Register</a>
                    @endauth
                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode" class="p-2 rounded bg-gray-700 dark:bg-gray-600 hover:bg-gray-600 dark:hover:bg-gray-500 focus:outline-none">
                        <svg x-show="!darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8-9h1m-16 0H3m15.364-6.364l-.707-.707m-12.02 12.02l-.707-.707m12.727 0l-.707.707M5.636 5.636l-.707-.707m6.364 15a9 9 0 110-18 9 9 0 010 18z" />
                        </svg>
                        <svg x-show="darkMode" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.293 14.707a8 8 0 01-11.414 0 8 8 0 1111.414 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <main class="flex-grow container mx-auto p-4">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 dark:bg-gray-900 text-center py-4 text-gray-400">
            <p>&copy; {{ date('Y') }} Laravel. All rights reserved.</p>
        </footer>
    </div>

    @livewireScripts
</body>
</html>
