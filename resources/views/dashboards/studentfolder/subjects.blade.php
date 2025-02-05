@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 lg:px-8 space-y-8 max-w-screen-xl pt-20">
    <h1 class="text-2xl font-bold">Subjects</h1>
    <p class="text-gray-600">List of subjects enrolled</p>

    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        @if($subjects->isEmpty())
            <p class="text-gray-500">No subjects found.</p>
        @else
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="p-3 text-left text-sm font-semibold text-gray-600"></th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Subject Name</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Description</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Instructors</th>
                        <th class="p-3 text-left text-sm font-semibold text-gray-600">Quizzes</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subject)
                        <tr class="border-b hover:bg-gray-50 transition-colors">
                            <td class="p-3 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="p-3 text-sm text-gray-700">{{ $subject->name }}</td>
                            <td class="p-3 text-sm text-gray-700">{{ $subject->description ?? 'No description' }}</td>
                            <td class="p-3 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>{{ $subject->instructors->pluck('name')->join(', ') ?: 'No instructors' }}</span>
                                </div>
                            </td>
                            <td class="p-3 text-sm text-gray-700">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                    <span>{{ $subject->quizzes->count() }}</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection