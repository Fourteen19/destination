@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Adviser content for institution: {{ $institution->name }}</h1>
            <p class="mydir-instructions">Use the form below to edit the institution's advisers details.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

<div class="row">
    <div class="col-lg-6">
@include('admin.pages.includes.flash-message')

{!! Form::open(['method' => 'PATCH', 'route' => ['admin.clients.institutions.advisers.update', ['client' => $client->uuid, 'institution' => $institution->uuid]]] ) !!}

    @include('admin.pages.institutions-advisers.form')

{!! Form::close() !!}
</div>
</div>

<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            <a class="mydir-action" href="{{ route('admin.clients.institutions.index', ['client' => $client->uuid]) }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>
@endsection
