@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <!-- Dashboard Header -->

    <div class="mt-12">
        @if (session()->has('success'))
            <x-toast-message type="success" :message="session('success')" />
        @endif
        @if (session()->has('error'))
            <x-toast-message type="error" :message="session('error')" />
        @endif
    </div>


    
    <div>
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-200">Instructor Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">
            Welcome to Quiz Manager
        </p>
    </div>


    <div>
    
    @livewire('question-manager')
    </div>
</div>
@endsection
