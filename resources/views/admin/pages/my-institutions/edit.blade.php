@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Adviser content for institution: {{ $institution->name }}</h1>
            <p class="mydir-instructions">Use the form below to edit the institution's details.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

<div class="row">
    <div class="col-lg-6">
@include('admin.pages.includes.flash-message')

{{-- 'client' => $client->uuid, --}}

{!! Form::model($institution, ['method' => 'PATCH','route' => ['admin.my-institutions.update', [ 'my_institution' => $institution->uuid]]] ) !!}

    @include('admin.pages.my-institutions.form')

{!! Form::close() !!}
</div>
</div>

<div class="row">
    <div class="col">
        <div class="mydir-controls mt-5">
            {{-- , ['client' => $client->uuid] --}}
            <a class="mydir-action" href="{{ route('admin.my-institutions.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
        </div>
    </div>
</div>
</div>
@endsection
