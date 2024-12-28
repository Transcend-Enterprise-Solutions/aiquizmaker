<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel - Vibrant Welcome</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 font-sans">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-blue-500 to-purple-600 text-white py-4">
            <div class="container mx-auto flex justify-between items-center px-6">
                <a href="#" class="text-2xl font-bold">Laravel</a>
                <div class="hidden md:flex space-x-6">
                    <a href="#counter" class="hover:underline">Counter</a>
                    <a href="#login" class="hover:underline">Login</a>
                    <a href="#register" class="hover:underline">Register</a>
                </div>
                <button id="theme-toggle" class="text-white focus:outline-none">
                    <svg id="light-icon" class="hidden w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v3m0 12v3m9-9h-3M3 12H0m15.364-7.364l-2.121 2.121M6.364 6.364l2.121 2.121m0 9.9l-2.121-2.121m9.9 0l-2.121-2.121"/>
                    </svg>
                    <svg id="dark-icon" class="w-6 h-6" fill="none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 1115.354 20.354a9 9 0 015 5z"/>
                    </svg>
                </button>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="bg-gradient-to-br from-blue-500 to-purple-600 text-white text-center py-20">
            <div class="container mx-auto">
                <h1 class="text-6xl font-bold mb-6">Discover Laravel</h1>
                <p class="text-xl text-gray-200 mb-6">Fast. Elegant. Powerful.</p>
                <div class="mt-8">
                    <a href="#register" class="bg-white text-blue-600 font-medium px-8 py-4 rounded-full shadow-md hover:bg-gray-200">
                        Get Started
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="py-12">
            <div class="container mx-auto space-y-16 px-6">
                <!-- Counter Section -->
                <section id="counter" class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-center">Interactive Counter</h2>
                    <livewire:counter />
                </section>

                <!-- Login Section -->
                <section id="login" class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-center">Login Modal</h2>
                    <livewire:login-modal />
                </section>

                <!-- Register Section -->
                <section id="register" class="bg-gray-100 dark:bg-gray-700 rounded-lg shadow-lg p-8">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4 text-center">Register Modal</h2>
                    <livewire:register-modal />
                </section>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-blue-500 to-purple-600 text-white text-center py-6">
            <p class="text-sm">
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
