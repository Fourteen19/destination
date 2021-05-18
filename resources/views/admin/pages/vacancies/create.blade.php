@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Create New {{ $contentOwner }} Vacancy</h1>
            <p class="mydir-instructions">From this screen you can enter all the details required to create a vacancy within the system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    @include('admin.pages.includes.flash-message')


    <form wire:submit.prevent="submit">

        @livewire('admin.vacancy-form', ['action' => 'add', 'vacancyUuid' => $vacancy])

    </form>

@endsection


@push('styles')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endpush
