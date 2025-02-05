<div class="p-6 bg-white shadow rounded-lg">
    <h2 class="text-xl font-semibold text-gray-800">Enrolled Subjects</h2>

    @if ($subjects->isEmpty())
        <p class="mt-4 text-gray-600">You are not enrolled in any subjects.</p>
    @else
        <ul class="mt-4 space-y-3">
            @foreach ($subjects as $subject)
                <li class="bg-gray-100 p-4 rounded-md shadow-sm">
                    <h3 class="text-lg font-medium text-gray-700">{{ $subject->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $subject->description }}</p>
                </li>
            @endforeach
        </ul>
    @endif
</div>