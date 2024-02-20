@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Marks</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All marks</h2>
        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <span>
                <a class='btn btn-outline-primary rounded-pill' href='{{ route('marks.create') }}'>
                    <i class='bi bi-plus'></i> Add marks
                </a>
            </span>
        @endif
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Student</th>
                <th scope="col">Subject</th>
                <th scope="col">Marks</th>
                <th scope="col">Year</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($marks as $key => $mark)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $mark->student->name }}</td>
                    <td>{{ $mark->subject->name }}</td>
                    <td>{{ $mark->marks }}</td>
                    <td>{{ $mark->year }}</td>
                    <td>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('student.show', $mark->student_id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('marks.edit', $mark->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                            <form action='{{ route('marks.destroy', $mark->id) }}' method='post' class='d-inline'>
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
    {{ $marks->links() }}
@endsection
