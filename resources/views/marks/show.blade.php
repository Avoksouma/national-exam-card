@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('paper.index') }}">Past Paper</a></li>
            <li class="breadcrumb-item active" aria-current="page">Paper Details</li>
        </ol>
    </nav>
    <div class="card card-body shadow-sm mb-3">
        <table class="table table-bordered table-hover mb-0">
            <tbody>
                <tr>
                    <th>Name</th>
                    <td>{{ $paper->name }}</td>
                </tr>
                <tr>
                    <th>Subject</th>
                    <td>{{ $paper->subject->name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $paper->description !!}</td>
                </tr>
                <tr>
                    <th>Document</th>
                    <td>
                        <a href='{{ asset('storage/' . $paper->document) }}' target="_blank"
                            class='btn btn-primary'>DOWNLOAD</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
