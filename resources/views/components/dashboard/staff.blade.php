<div class='row'>
    <div class='col-md-3'>
        <div class='card card-body border-0 bg-success text-white shadow-sm'>
            <h5 class='fw-normal text-uppercase'>{{ __('School') }}</h5>
            <h1>{{ $schools }} <i class="bi bi-building float-end"></i></h1>
            <p class="text-white mb-0">12% {{ __('from last month') }}</p>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='card card-body border-0 bg-info shadow-sm'>
            <h5 class='fw-normal text-uppercase'>{{ __('Students') }}</h5>
            <h1>{{ $students }} <i class="bi bi-mortarboard float-end"></i></h1>
            <p class="text-muted mb-0">12% {{ __('from last month') }}</p>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='card card-body border-0 bg-secondary text-white shadow-sm'>
            <h5 class='fw-normal text-uppercase'>{{ __('Application') }}</h5>
            <h1>{{ $applications }} <i class="bi bi-collection float-end"></i></h1>
            <p class="text-white mb-0">12% {{ __('from last month') }}</p>
        </div>
    </div>
    <div class='col-md-3'>
        <div class='card card-body border-0 bg-warning shadow-sm'>
            <h5 class='fw-normal text-uppercase'>{{ __('Approved') }}</h5>
            <h1>0 <i class="bi bi-person-check float-end"></i></h1>
            <p class="text-muted mb-0">12% {{ __('from last month') }}</p>
        </div>
    </div>
</div>
<div class="col-12 mt-2">
    <h3 class='my-3'>{{ __('Top Students') }}</h3>
    <canvas id="myChart" width="400" height="150"></canvas>
</div>
