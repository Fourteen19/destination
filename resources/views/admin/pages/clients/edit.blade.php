@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Client</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.clients.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.includes.form.errors')

{!! Form::model($client, ['method' => 'PATCH','route' => ['admin.clients.update', $client->uuid]]) !!}

    @include('admin.pages.clients.form')

{!! Form::close() !!}

@endsection

@include('admin.pages.clients.form_js')