@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Student</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student Profile</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3">
        <div class="d-flex flex-row">
            @if ($student->image)
                <img alt='{{ $student->first_name }}' src='{{ asset('storage/' . $student->image) }}' width='120'
                    height='120' style='object-fit:cover' class='rounded-pill me-3 my-auto' />
            @endif
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Full names</th>
                        <th>School</th>
                        <th>Birth date</th>
                        <th>Guardian</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td>{{ $student->school->name }}</td>
                        <td>{{ $student->dob }}</td>
                        <td>
                            {{ $student->contact_person }} <br />
                            {{ $student->contact_details }}
                        </td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td colspan="3">{!! $student->description !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
