@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Profile</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3">
        <div class="d-flex flex-row">
            @if ($user->image)
                <img alt='{{ $user->name }}' src='{{ asset('storage/' . $user->image) }}' width='120' height='120'
                    style='object-fit:cover' class='rounded-pill me-3 my-auto' />
            @endif
            <table class="table table-bordered table-hover mb-0">
                <tbody>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>{{ $user->role }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @if ($user->role == 'student')
        @if ($applications->count())
            <h3>Applications</h3>
        @endif
        <table class="table table-bordered table-hover">
            @if ($applications->count())
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Birth Date</th>
                        <th scope="col">School</th>
                        <th scope="col">Contact Person</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($applications as $key => $student)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>
                            @if ($student->image)
                                <img alt='{{ $student->first_name }}' src='{{ asset('storage/' . $student->image) }}'
                                    width='40' height='40' style='object-fit:cover' class='rounded-pill me-1' />
                            @endif
                            {{ $student->first_name }} {{ $student->last_name }}
                        </td>
                        <td>{{ $student->status }}</td>
                        <td>{{ $student->dob }}</td>
                        <td>{{ $student->school->name }}</td>
                        <td>{{ $student->contact_person }} {{ $student->contact_details }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $applications->links() }}

        @if ($marks->count())
            <h3>Marks</h3>
        @endif
        <table class="table table-bordered table-hover">
            @if ($marks->count())
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Student</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Marks</th>
                        <th scope="col">Year</th>
                    </tr>
                </thead>
            @endif
            <tbody>
                @foreach ($marks as $key => $mark)
                    <tr>
                        <th scope="row">{{ $key + 1 }}</th>
                        <td>{{ $mark->student->name }}</td>
                        <td>{{ $mark->subject->name }}</td>
                        <td>{{ $mark->marks }}</td>
                        <td>{{ $mark->year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $marks->links() }}
    @endif
@endsection
