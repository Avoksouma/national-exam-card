@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All students</h2>
        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <span>
                <a class='btn btn-outline-primary rounded-pill' href='{{ route('student.create') }}'>
                    <i class='bi bi-plus'></i> Add student
                </a>
            </span>
        @endif
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Birth Date</th>
                <th scope="col">School</th>
                <th scope="col">Contact Person</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $key => $student)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        @if ($student->image)
                            <img alt='{{ $student->first_name }}' src='{{ asset('storage/' . $student->image) }}'
                                width='40' height='40' style='object-fit:cover' class='rounded-pill me-1' />
                        @endif
                        {{ $student->first_name }} {{ $student->last_name }}
                    </td>
                    <td>{{ $student->dob }}</td>
                    <td>{{ $student->school->name }}</td>
                    <td>{{ $student->contact_person }} {{ $student->contact_details }}</td>
                    <td>
                        @if (Auth::user()->role == 'sponsor')
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('student.show', $student->id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a href='{{ route('student.support', $student->id) }}' class='btn btn-sm btn-info'
                                    data-toggle="tooltip" title="Sponsor child">
                                    <i class='bi bi-check'></i>
                                </a>
                            </div>
                        @endif
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('student.show', $student->id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('student.edit', $student->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                            <form action='{{ route('student.destroy', $student->id) }}' method='post' class='d-inline'>
                                @csrf @method('delete')
                                <button class='btn btn-sm btn-warning'>
                                    <i class='bi bi-trash'></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $students->links() }}
@endsection
