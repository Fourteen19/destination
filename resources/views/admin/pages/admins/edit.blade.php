@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit Admin</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('admin.admins.index') }}"> Back</a>
        </div>
    </div>
</div>

@include('admin.pages.includes.form.errors')

{!! Form::model($admin, ['method' => 'PATCH','route' => ['admin.admins.update', $admin->uuid]]) !!}

    @include('admin.pages.admins.form')

{!! Form::close() !!}

@endsection

@include('admin.pages.admins.form_js')