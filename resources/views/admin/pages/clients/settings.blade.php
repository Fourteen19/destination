@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Client Branding for "{{$client->name}}"</h1>
            <p class="mydir-instructions">This screen allows you to control the colours, fonts and logo used within a client system.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <form wire:submit.prevent="submit">

        @livewire('admin.client-settings-form', ['uuid' => $client->uuid])

    </form>

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.clients.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>

@endsection
