@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('marks.index') }}">Marks</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Marks</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-center align-items-center h-75'>
        <div class='text-center w-75'>
            <form action='{{ route('marks.update', $mark->id) }}' method='post' enctype="multipart/form-data">
                <h2 class='mb-3'>Edit marks details</h2>
                @include('components.message')
                <div class='row'>
                    <div class='col-md-4'>
                        <select name="student" class="form-select mb-3">
                            <option value="{{ $mark->student_id }}">{{ $mark->student->name }}</option>
                            @foreach ($students as $student)
                                <option value='{{ $student->id }}'>{{ $student->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-4'>
                        <select name="subject" class="form-select mb-3">
                            <option value="{{ $mark->subject_id }}">{{ $mark->subject->name }}</option>
                            @foreach ($subjects as $subject)
                                <option value='{{ $subject->id }}'>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class='col-md-4'>
                        <input class='form-control mb-3' type='number' min='0' max='100' name='marks'
                            placeholder='marks' value='{{ $mark->marks }}' />
                    </div>
                    <div class='col-md-4'>
                        <input class='form-control mb-3' type='number' min='1900' max='2100' name='year'
                            placeholder='year' value='{{ $mark->year }}' />
                    </div>
                </div>
                @csrf @method('put')
                <div class='d-flex justify-content-between mt-3'>
                    <button type='submit' class='btn btn-primary rounded-pill w-10'>Submit</button>
                    <a href='{{ route('marks.index') }}' class='btn btn-outline-primary rounded-pill w-10'>
                        All marks
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
