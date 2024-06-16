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
@if (in_array(Auth::user()->role, ['staff', 'admin']))
    @section('scripts')
        <script src="/vendor/chartjs/chart.min.js"></script>
        <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const applicationCtx = document.getElementById('applicationChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        @foreach ($marks as $mark)
                            '{{ $mark->student->name }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Marks',
                        data: [
                            @foreach ($marks as $mark)
                                {{ $mark->total_marks }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            const applicationChart = new Chart(applicationCtx, {
                type: 'pie',
                data: {
                    labels: [
                        @foreach ($applicants as $applicant)
                            '{{ $applicant->status }}',
                        @endforeach
                    ],
                    datasets: [{
                        label: 'Student Applications',
                        data: [
                            @foreach ($applicants as $applicant)
                                {{ $applicant->total }},
                            @endforeach
                        ],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endsection
@endif
