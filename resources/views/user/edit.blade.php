@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">User</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit User</li>
        </ol>
    </nav>
    <div class='d-flex justify-content-center align-items-center h-75'>
        <div class='text-center w-75'>
            <form action='{{ route('user.update', $user->id) }}' method='post' enctype="multipart/form-data">
                <h2 class='mb-3'>Edit user</h2>
                @include('components.message')
                <div class='row'>
                    <div class='col-md-4'>
                        <input class='form-control mb-3' name='name' placeholder='user name'
                            value='{{ $user->name }}' />
                    </div>
                    <div class='col-md-4'>
                        <select name="role" class="form-select mb-3">
                            <option value="{{ $user->role }}">{{ $user->role }}</option>
                            <option value="student">student</option>
                            <option value="staff">staff</option>
                            <option value="admin">admin</option>
                        </select>
                    </div>
                    <div class='col-md-4'>
                        <input class='form-control mb-3' disabled name='email' value='{{ $user->email }}' />
                    </div>
                </div>
                @csrf @method('put')
                <div class='d-flex justify-content-between mt-3'>
                    <button type='submit' class='btn btn-primary rounded-pill w-10'>Submit</button>
                    <a href='{{ route('user.index') }}' class='btn btn-outline-primary rounded-pill w-10'>
                        All users
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
