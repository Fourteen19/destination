@extends('frontend.layouts.master')


@section('content')
<section class="p-w">
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-10">
            <div class="row r-pad">
                <div class="col-lg-8 offset-lg-1 col-md-10 offset-md-1">
                    <h1 class="t36 fw700">Welcome {{ Auth::guard('web')->user()->first_name }}</h1>
                    {!! $data['welcome_intro'] !!}
                    <form wire:submit.prevent="submit">
                        @livewire('frontend.terms-and-conditions-form')
                    <form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<div class="sa-image">
    <div class="over-img">
        <img src="{{ asset('images/welcome-screen.png') }}" alt="Welcome to MyDirections">
    </div>
    <div class="bg-image">
        <svg xmlns="http://www.w3.org/2000/svg" width="1920" height="391" viewBox="0 0 3840 782" class="w-100" style="height: auto;">
        <path class="welcome-swoosh" d="M24,2092l3846-168v410L24,2706V2092Z" transform="translate(-25 -1924)"/>
        </svg>
    </div>
</div>

{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">{{ __('Welcome Screen') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>{{ __('You are logged in!') }}</p>

                    <p>Your name is {{ Auth::user()->FullName }}</p>

                    <p>Your institution is: {{ Auth::user()->institution->name }}</p>

                    <p>You need to complete your profile</p>

                    <p><a href="{{ route('frontend.self-assessment.terms.edit') }}">Self Assessment</a></p>

                </div>





            </div>

        </div>
    </div>
</div>
--}}
@endsection
