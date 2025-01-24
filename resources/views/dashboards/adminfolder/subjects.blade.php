@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Subjects</h1>
    <ul class="list-group mt-3">
        @foreach ($subjects as $subject)
            <li class="list-group-item">
                {{ $subject->name }}
                <small class="text-muted">({{ $subject->description }})</small>
            </li>
        @endforeach
    </ul>
</div>
@endsection
