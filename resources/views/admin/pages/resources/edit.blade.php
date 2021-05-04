@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Edit Teaching Resource</h1>
            <p class="mydir-instructions">From this screen you can edit the details for the selected teaching resource.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    @include('admin.pages.includes.flash-message')

    {!! Form::model($resource, ['method' => 'PATCH','route' => ['admin.resources.update', $resource->uuid]]) !!}

        @include('admin.pages.resources.form')

    {!! Form::close() !!}

    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.resources.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>

@endsection
