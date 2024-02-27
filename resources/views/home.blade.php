@extends('layouts.default')
@section('content')
    <div class="row my-3">
        <div class="col-md-6">
            <img alt='illustrations' src='/img/students.svg' class='w-100' />
        </div>
        <div class="col-md-6 my-auto">
            <h1>{{ __('National Exam Card Application Management System') }}</h1>
            <p>
                {{ __('The Office National des Examens et Concours du Superieur commonly referred to as ONECS is a key institution in Chad responsible for overseeing and managing examination and admission process for higher education institutions in the country') }}....
            </p>
        </div>
        <div class="col-12">
            <hr class='border-3 border-secondary my-md-5'>
            <h1 class='text-center'>{{ __('Key Features') }}</h1>
        </div>
        <div class="col-md-4 text-center">
            <img alt='illustrations' src='/img/server.jpg' class='w-50' />
            <h3>{{ __('Accessible') }}</h3>
            <p>{{ __('Get access from anywhere via internet') }}</p>
        </div>
        <div class="col-md-4 text-center">
            <img alt='illustrations' src='/img/information.jpg' class='w-50' />
            <h3>{{ __('Informative') }}</h3>
            <p>{{ __('Apply for exam cards, check marks, view academic calendar, download past papers') }}</p>
        </div>
        <div class="col-md-4 text-center">
            <img alt='illustrations' src='/img/privacy.jpg' class='w-50' />
            <h3>{{ __('Secure') }}</h3>
            <p>{{ __('Your data and privacy is our priority') }}</p>
        </div>
    </div>
@endsection
