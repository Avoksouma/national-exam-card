@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('application.index') }}">Student Application</a></li>
            <li class="breadcrumb-item active" aria-current="page">Application Details</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3">
        <div class="d-flex flex-row">
            @if ($application->image)
                <img alt='{{ $application->first_name }}' src='{{ asset('storage/' . $application->image) }}' width='120'
                    height='120' style='object-fit:cover' class='rounded-pill me-3 my-auto' />
            @endif
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Full names</th>
                        <th>School</th>
                        <th>Birth date</th>
                        <th>Mother</th>
                        <th>Father</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $application->first_name }} {{ $application->last_name }}</td>
                        <td>{{ $application->school->name }}</td>
                        <td>{{ $application->dob }}</td>
                        <td>{{ $application->mother }}</td>
                        <td>{{ $application->father }}</td>
                    </tr>
                    <tr>
                        <th>Combination</th>
                        <th>Gender</th>
                        <th>City</th>
                        <th>Contact Person</th>
                        <th>Contact Details</th>
                    </tr>
                    <tr>
                        <td>{{ $application->combination->name }}</td>
                        <td>{{ $application->gender }}</td>
                        <td>{{ $application->city }}</td>
                        <td>{{ $application->contact_person }}</td>
                        <td>{{ $application->contact_details }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <th colspan='4'>Description</th>
                    </tr>
                    <tr>
                        <td>
                            <span class='badge {{ $colors[$application->status] }}'>
                                {{ $application->status }}
                            </span>
                        </td>
                        <td colspan="4">{!! $application->description !!}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
