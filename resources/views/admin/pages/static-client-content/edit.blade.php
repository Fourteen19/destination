@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Client Static Content</h1>
            <p class="mydir-instructions">From this screen you can control all of the static (or constant) content that appears through out your system. NOTE: Making a change here will instantly publish the changes to the live system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>


    <form wire:submit.prevent="submit">

        @livewire('admin.client-static-content')

    </form>

</div>
@endsection
