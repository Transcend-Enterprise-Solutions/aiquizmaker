@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <!-- Dashboard Header -->
    <div class="flex items-center justify-between mt-12 mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-200">Instructor Dashboard</h1>
        <a href="{{ route('instructor.quiz') }}" class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-700 dark:hover:bg-indigo-800 dark:focus:ring-indigo-900">
            Create Quiz
        </a>
    </div>

    <!-- Success/Error Toast Notifications -->
    <div>
        @if (session()->has('success'))
            <x-toast-message type="success" :message="session('success')" />
        @endif
        @if (session()->has('error'))
            <x-toast-message type="error" :message="session('error')" />
        @endif
    </div>

    <!-- Welcome Section -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <p class="text-lg text-gray-700 dark:text-gray-400">
            Welcome to your dashboard, where you can manage your students, create quizzes, and track progress.
        </p>
    </div>

    <!-- Dashboard Cards Section -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
        <!-- Card 1: Total Students -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Students</h3>
            <p class="mt-2 text-3xl text-indigo-600 dark:text-indigo-400">125</p>
        </div>

        <!-- Card 2: Active Courses -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Active Courses</h3>
            <p class="mt-2 text-3xl text-green-600 dark:text-green-400">8</p>
        </div>

        <!-- Card 3: Pending Quizzes -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Pending Quizzes</h3>
            <p class="mt-2 text-3xl text-yellow-600 dark:text-yellow-400">3</p>
        </div>
    </div>

    <!-- Additional Action Section -->
    <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">Quick Actions</h2>
        <p class="mt-4 text-gray-700 dark:text-gray-400">Take quick actions for managing your courses and students.</p>

        <div class="mt-6 space-x-4">
            <a href="{{ route('instructor.quiz') }}" class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-900">
                Create New Quiz
            </a>
            <a href="#" class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-gray-800 bg-gray-200 rounded-lg hover:bg-gray-300 focus:ring-4 focus:ring-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-800">
                View All Courses
            </a>
        </div>
    </div>
</div>

<section class="bg-white dark:bg-gray-900">
    <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
        <div class="flex flex-col justify-center">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">Why enroll here?</h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">Idk, don't enroll</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0">
                <a href="#" class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-900">
                    Get started
                    <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                    </svg>
                </a>
                <a href="#" class="py-3 px-5 sm:ms-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Learn more
                </a>
            </div>
        </div>
        <div>
            <iframe class="mx-auto w-full lg:max-w-xl h-64 rounded-lg sm:h-96 shadow-xl" src="https://www.youtube.com/embed/-yctyMDZ6B0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</section>
@endsection
