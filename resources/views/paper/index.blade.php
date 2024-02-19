@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Past Paper</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All past papers</h2>
        @if (in_array(Auth::user()->role, ['admin', 'staff']))
            <span>
                <a class='btn btn-outline-primary rounded-pill' href='{{ route('paper.create') }}'>
                    <i class='bi bi-plus'></i> Add paper
                </a>
            </span>
        @endif
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($papers as $key => $paper)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>{{ $paper->name }}</td>
                    <td>{{ $paper->subject->name }}</td>
                    <td>{!! $paper->description !!}</td>
                    <td>
                        <div class='btn-group'>
                            <a class='btn btn-sm btn-success' href='{{ route('paper.show', $paper->id) }}'>
                                <i class='bi bi-eye'></i>
                            </a>
                            @if (in_array(Auth::user()->role, ['admin', 'staff']))
                                <a class='btn btn-sm btn-info' href='{{ route('paper.edit', $paper->id) }}'>
                                    <i class='bi bi-pencil'></i>
                                </a>
                            @endif
                        </div>
                        @if (in_array(Auth::user()->role, ['admin', 'staff']))
                            <form action='{{ route('paper.destroy', $paper->id) }}' method='post' class='d-inline'>
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
    {{ $papers->links() }}
@endsection
