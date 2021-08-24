@extends('frontend.layouts.master')

@section('content')

<div class="row mt-5 mb-3">
    <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
        <div class="pt-4">
            <h1 class="fw700 t36 mb-4">Welcome to the MyDirections CV Builder</h1>
            {{$staticContent['cv_introduction']}}
            {!!$staticContent['cv_useful_articles']!!}
            <a href="{{ route('frontend.cv-builder.edit') }}" class="platform-button alt-button ml-auto">Get Started</a>
        </div>
    </div>
</div>

@include('frontend.pages.includes.hot-right-now')

<div class="row">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

