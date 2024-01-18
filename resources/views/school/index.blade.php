@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">School</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All schools</h2>
        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <span>
                <a class='btn btn-outline-primary rounded-pill' href='{{ route('school.create') }}'>
                    <i class='bi bi-plus'></i> Add school
                </a>
            </span>
        @endif
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Contact</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schools as $key => $school)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        @if ($school->image)
                            <img alt='{{ $school->name }}' src='{{ asset('storage/' . $school->image) }}' width='40'
                                height='40' style='object-fit:cover' class='rounded-pill me-1' />
                        @endif
                        {{ $school->name }}
                    </td>
                    <td>{{ $school->contact }}</td>
                    <td>{!! $school->description !!}</td>
                    <td>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('school.show', $school->id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('school.edit', $school->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                            <form action='{{ route('school.destroy', $school->id) }}' method='post' class='d-inline'>
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
    {{ $schools->links() }}
@endsection
