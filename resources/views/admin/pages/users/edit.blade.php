@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.users.index') }}">Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.form.errors')

{!! Form::model($user, ['method' => 'PATCH','route' => ['admin.users.update', $user->uuid]]) !!}

    @include('admin.pages.users.form')

{!! Form::close() !!}

@endsection