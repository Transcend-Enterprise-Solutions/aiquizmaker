<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - Modern Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <a href="#" class="text-2xl font-bold text-blue-600 dark:text-blue-400">Laravel</a>
                    <div class="hidden md:flex space-x-6">
                        <a href="#counter" class="hover:text-blue-500">Counter</a>
                        <livewire:login-modal />
                        <livewire:register-modal />
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="theme-toggle" class="focus:outline-none text-gray-600 dark:text-gray-300">
                            <svg id="light-icon" class="hidden w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m0 12v3m9-9h-3M3 12H0m15.364-7.364l-2.121 2.121M6.364 6.364l2.121 2.121m0 9.9l-2.121-2.121m9.9 0l-2.121-2.121"/>
                            </svg>
                            <svg id="dark-icon" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 1115.354 20.354a9 9 0 015 5z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-20">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-5xl font-bold mb-4">Welcome to Laravel</h1>
                <p class="text-lg">Start building modern applications with simplicity and elegance.</p>
                <a href="#register" class="mt-8 inline-block bg-white text-blue-600 font-medium px-6 py-3 rounded-full shadow hover:bg-gray-100">Get Started</a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-16 bg-gray-50 dark:bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <!-- Counter Section -->
                <section id="counter" class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Counter Component</h2>
                    <livewire:counter />
                </section>

                <!-- Login Section -->
                <section id="login" class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Login Modal</h2>
                    <livewire:login-modal />
                </section>

                <!-- Register Section -->
                <section id="register" class="bg-white dark:bg-gray-800 rounded-lg shadow p-8">
                    <h2 class="text-3xl font-semibold mb-4 text-center">Register Modal</h2>
                    <livewire:register-modal />
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gray-100 dark:bg-gray-800 text-center py-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </p>
        </footer>

        @livewireScripts

        <!-- Theme Toggle Script -->
        <script>
            const themeToggle = document.getElementById('theme-toggle');
            const lightIcon = document.getElementById('light-icon');
            const darkIcon = document.getElementById('dark-icon');

            themeToggle.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                lightIcon.classList.toggle('hidden');
                darkIcon.classList.toggle('hidden');
                localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
            });

            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        </script>
    </body>
</html>
