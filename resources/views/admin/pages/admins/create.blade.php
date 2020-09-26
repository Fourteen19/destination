@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.admins.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.includes.form.errors')

{!! Form::model($admin, ['method' => 'POST','route' => ['admin.admins.store']]) !!}

    @include('admin.pages.admins.form')

{!! Form::close() !!}

@endsection

@include('admin.pages.admins.form_js')