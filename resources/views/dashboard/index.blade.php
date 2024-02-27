@extends('layouts.dashboard')
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('Dashboard') }}</li>
        </ol>
    </nav>
    <div class='d-flex flex-row'>
        <img class='my-auto me-3 rounded-pill' alt='{{ Auth::user()->name }}' src='/img/user.png' height='75'
            width='75' />
        <div>
            <h3 class='fw-normal'>{{ __('Welcome') }}, {{ Auth::user()->name }}</h3>
            <p class="text-muted mb-0">{{ __('These are your analytics stats for today') }} {{ today()->format('F d, Y') }}
            </p>
        </div>
    </div>
    <hr>
    @if (in_array(Auth::user()->role, ['staff', 'admin']))
        @include('components.dashboard.staff')
    @else
        @include('components.dashboard.student')
    @endif
@endsection
