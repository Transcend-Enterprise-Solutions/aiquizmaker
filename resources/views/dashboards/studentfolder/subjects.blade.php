@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h2 class="text-xl font-semibold text-gray-800">Enrolled Subjects</h2>

    @if ($enrolledSubjects->isEmpty())
        <p class="mt-4 text-gray-600">You are not enrolled in any subjects.</p>
    @else
        <ul class="mt-4 space-y-3">
            @foreach ($enrolledSubjects as $subject)
                <li class="bg-gray-100 p-4 rounded-md shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">{{ $subject->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $subject->description }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
