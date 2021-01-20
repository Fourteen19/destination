@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Global Settings</h1>
            <p class="mydir-instructions">Use this screen to manage all system settings applicable to all clients.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <form wire:submit.prevent="submit">

        @livewire('admin.global-settings-form')

    </form>

</div>

@endsection
