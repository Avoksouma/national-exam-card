@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Subject</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All subjects</h2>
        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <span>
                <a class='btn btn-outline-primary rounded-pill' href='{{ route('subject.create') }}'>
                    <i class='bi bi-plus'></i> Add subject
                </a>
            </span>
        @endif
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $key => $subject)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        @if ($subject->image)
                            <img alt='{{ $subject->name }}' src='{{ asset('storage/' . $subject->image) }}' width='40'
                                height='40' style='object-fit:cover' class='rounded-pill me-1' />
                        @endif
                        {{ $subject->name }}
                    </td>
                    <td>{!! $subject->description !!}</td>
                    <td>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <div class='btn-group'>
                                <a class='btn btn-sm btn-success' href='{{ route('subject.show', $subject->id) }}'>
                                    <i class='bi bi-eye'></i>
                                </a>
                                <a class='btn btn-sm btn-info' href='{{ route('subject.edit', $subject->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            </div>
                            <form action='{{ route('subject.destroy', $subject->id) }}' method='post' class='d-inline'>
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
    {{ $subjects->links() }}
@endsection
