@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit {{ $contentOwner }} Activity</h1>
            <p class="mydir-instructions">Use the form below to edit the selected work experience activity.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    @include('admin.pages.includes.flash-message')

    <form wire:submit.prevent="submit">
        @livewire('admin.content-activity-form', ['action' => 'edit', 'contentUuid' => $content])
    </form>
@endsection

@include('admin.pages.contents.includes.shared-styles-js')
