@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <!-- Dashboard Header -->
    <div class="flex items-center justify-between mt-12 mb-8">
        <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-200">Admin Dashboard</h1>
    </div>

    <!-- Welcome Section -->
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <p class="text-lg text-gray-700 dark:text-gray-400">
            Welcome to the admin dashboard! Use this space to oversee and manage system operations efficiently.
        </p>
    </div>
    <livewire:search-students />


</div>
@endsection
