@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h2 class="text-xl font-semibold text-gray-800">Your Quizzes</h2>
    <livewire:student-quizzes />
 
</div>
@endsection
