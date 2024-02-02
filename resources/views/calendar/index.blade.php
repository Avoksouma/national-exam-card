@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Calendar</li>
        </ol>
    </nav>
    <div id="root"></div>
@endsection
@section('styles')
    <link href="/css/react-calendar.css" rel="stylesheet">
@endsection
@section('scripts')
    <script src="/vendor/react.production.min.js"></script>
    <script src="/vendor/react-dom.production.min.js"></script>
    <script src="/js/react-calendar.js"></script>
@endsection
