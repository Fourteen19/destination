@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Insitution</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.clients.institutions.index', [ 'client' => $client->uuid ]) }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{!! Form::model($institution, ['method' => 'POST','route' => ['admin.clients.institutions.store', [ 'client' => $client->uuid ]]]) !!}

    @include('admin.pages.institutions.form')

{!! Form::close() !!}

@endsection