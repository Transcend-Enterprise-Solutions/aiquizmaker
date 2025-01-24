@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Manage Subjects</h1>
    <a href="{{ route('admin.assignSubject') }}" class="btn btn-primary">Assign Subjects</a>
    <ul class="list-group mt-3">
        @foreach ($subjects as $subject)
            <li class="list-group-item">{{ $subject->name }}</li>
        @endforeach
    </ul>
</div>
@endsection
