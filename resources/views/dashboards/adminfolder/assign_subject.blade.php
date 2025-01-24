@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Assign Subject to Students</h1>
    <form action="{{ route('admin.storeAssignSubject') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select id="student_id" name="student_id" class="form-select" required>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="subject_id" class="form-label">Select Subject</label>
            <select id="subject_id" name="subject_id" class="form-select" required>
                @foreach ($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Assign Subject</button>
    </form>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif
</div>
@endsection
