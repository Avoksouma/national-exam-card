@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-between'>
        <h2>All notifications</h2>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Message</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $key => $notification)
                <tr>
                    <th scope="row">{{ $key + 1 }}</th>
                    <td>
                        {{ $notification->title }}
                    </td>
                    <td>{!! $notification->content !!}</td>
                    <td>
                        <div class='btn-group'>
                            <a class='btn btn-sm btn-success' href='{{ $notification->url }}'>
                                <i class='bi bi-eye'></i>
                            </a>
                        </div>
                        <form action='{{ route('notification.destroy', $notification->id) }}' method='post'
                            class='d-inline'>
                            @csrf @method('delete')
                            <button class='btn btn-sm btn-warning'>
                                <i class='bi bi-trash'></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $notifications->links() }}
@endsection
