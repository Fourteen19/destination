@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.clients.institutions.users.index', ['client' => $client->uuid, 'institution' => $institution->uuid, 'user' => $user->uuid ]) }}">Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.flash-message')

{!! Form::model($user, ['method' => 'PATCH','route' => ['admin.clients.institutions.users.update', [ 'client' => $client, 'institution' => $institution, 'user' => $user->uuid]]] ) !!}

    @include('admin.pages.users.form')

{!! Form::close() !!}

@endsection