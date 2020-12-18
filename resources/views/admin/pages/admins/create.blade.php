@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">Create Admin User</h1>
            <p class="mydir-instructions">Eu laborum ipsum nisi incididunt cupidatat. Aute mollit laboris commodo magna voluptate enim irure non et enim pariatur officia fugiat irure. Sunt velit nostrud qui ullamco velit consequat in eu dolor eu exercitation laboris. Sit dolore quis sunt minim nostrud quis occaecat deserunt culpa dolor qui aliqua labore.</p>
            
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

@include('admin.pages.admins.form_js')