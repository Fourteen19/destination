@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Institution</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.clients.institutions.index', ['client' => $client->uuid, 'institution' => $institution->uuid]) }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.form.errors')

{!! Form::model($institution, ['method' => 'PATCH','route' => ['admin.clients.institutions.update', ['client' => $client->uuid, 'institution' => $institution->uuid]]] ) !!}

    @include('admin.pages.institutions.form')

{!! Form::close() !!}

@endsection