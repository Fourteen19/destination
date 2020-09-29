@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.users.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.form.errors')
clients.institutions.users
{!! Form::model($user, ['method' => 'POST','route' => ['admin.users.store']]) !!}

    @include('admin.pages.users.form')

{!! Form::close() !!}

@endsection