@extends('frontend.layouts.master')

@section('content')

<div class="row mt-5 mb-3">
    <div class="col-xl-7 col-lg-6 mb-4 mb-xl-0">
        <div class="pt-4">
            <h1 class="fw700 t36 mb-4">Instructions</h1>
            <p>Dynamic instructions text ?</p>
            @livewire('frontend.cv-builder-form')
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

