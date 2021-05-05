@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">

            <h1 class="mb-4">Create Admin User</h1>
            <p class="mydir-instructions">Use the form below to create an admin user.</p>

        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <div class="row">
        <div class="col-lg-6">

            @include('admin.pages.includes.flash-message')

            {!! Form::model($admin, ['method' => 'POST','route' => ['admin.admins.store']]) !!}

                @include('admin.pages.admins.form')

            {!! Form::close() !!}
        </div>
    </div>


    <div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.admins.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>

</div>
@endsection

