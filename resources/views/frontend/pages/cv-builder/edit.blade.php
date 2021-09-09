@extends('frontend.layouts.master')

@section('content')

@include('frontend.pages.cv-builder.includes.cv-banner')

<div class="px-lg-4">
    <div class="row">
        <div class="col-lg-8">
            <h1 class="fw700 t24 mb-3">Instructions</h1>
            <p>{{ $staticContent['cv_instructions'] }}</p>
        </div>
    </div>
</div>

@livewire('frontend.cv-builder-form')

<div class="row mt-5">
    <div class="col">
        <div class="border-top def-border pt-3 pl-3">
            <a href="{{ route('frontend.dashboard') }}" class="fw700 td-no">Back to home page</a>
        </div>
    </div>
</div>

@endsection

