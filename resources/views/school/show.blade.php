@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('school.index') }}">School</a></li>
            <li class="breadcrumb-item active" aria-current="page">School Profile</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3">
        <div class="d-flex flex-row">
            @if ($school->image)
                <img alt='{{ $school->first_name }}' src='{{ asset('storage/' . $school->image) }}' width='120'
                    height='120' style='object-fit:cover' class='rounded-pill me-3 my-auto' />
            @endif
            <table class="table table-bordered table-hover mb-0">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $school->name }}</td>
                    </tr>
                    <tr>
                        <th>Contact</th>
                        <td>{{ $school->contact }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{!! $school->description !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
