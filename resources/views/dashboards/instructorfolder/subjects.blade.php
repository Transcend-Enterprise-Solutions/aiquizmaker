@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h1 class="text-2xl font-bold">Subjects</h1>
    <p class="text-gray-600">Manage all subjects here.</p>

    <div class="mt-6 bg-white p-4 rounded-lg shadow">
     <livewire:subject-list />
    </div>
</div>
@endsection
