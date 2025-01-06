<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School LMS Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body class="bg-blue-50">
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Left Section -->
        <div class="relative md:w-3/4 flex flex-col">
            <!-- Video Section -->
            <div class="relative flex-1 bg-black">
                <!-- Video Background -->
                <video class="absolute inset-0 w-full h-full object-cover" autoplay muted loop playsinline>
                    <source src="{{ asset('images/videoplayback.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>

                <!-- Gradient Overlay -->
                <div class="absolute inset-0 bg-gradient-to-b from-black via-transparent to-gray-900 opacity-75"></div>


            </div>

            <!-- Text Section -->
            <div class="bg-gray-900 text-white p-8">
                <div class="max-w-2xl mx-auto text-center animate-fade-in">
                    <!-- Heading -->
                    <h1 class="text-4xl font-extrabold leading-tight mb-6">
                        Explore the world’s leading <span class="text-yellow-300">learning opportunities</span>.
                    </h1>

                    <!-- Description -->
                    <p class="text-lg text-gray-300 mb-8">
                        Millions of students and professionals around the world trust WCC for education, skills, and opportunities to shape their future.
                    </p>

                    <!-- Student Initials -->
                    <div class="flex items-center justify-center space-x-4 p-8">
                        <x-student-initials />
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="md:w-1/4 bg-white flex justify-center items-center p-8 shadow-lg border-l border-gray-200">
            <div class="w-full max-w-md">
                <!-- Logo and Heading -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/wc_logo_497x265.png') }}" alt="School Logo" class="w-16 mx-auto">
                    <h2 class="text-2xl font-bold mt-4 text-gray-700">World Citi Colleges</h2>
                </div>

                <!-- Login Modal -->
                <div class="space-y-6">
                    <livewire:login-modal />
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-sm text-gray-600">
                    <p class="mt-6 text-gray-400 italic">
                        <strong>James 1:5</strong> — If you need wisdom, ask our generous God, and He will give it to you. He will not rebuke you for asking.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <style>
        /* Add subtle fade-in animation */
        .animate-fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>