@extends('frontend.layouts.master')

@section('content')

@include('frontend.pages.cv-builder.includes.cv-banner')


<div class="px-lg-4">
    <div class="row justify-content-between">
        <div class="col-lg-6">
            <h1 class="fw700 t36 mb-4">Welcome to the MyDirections CV Builder</h1>
            <p>{{$staticContent['cv_introduction']}}</p>
            <a href="{{ route('frontend.cv-builder.edit') }}" class="platform-button mt-3">{{$cvBuilderButtonLabel}}</a>
        </div>
        <div class="col-lg-4">
            <h2 class="fw700 t24 mb-4">Useful Articles</h2>
            {!!$staticContent['cv_useful_articles']!!}
        </div>
    </div>
</div>



<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

