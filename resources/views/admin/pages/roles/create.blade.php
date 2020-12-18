@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">Create Role</h1>
            <p class="mydir-instructions">Eu laborum ipsum nisi incididunt cupidatat. Aute mollit laboris commodo magna voluptate enim irure non et enim pariatur officia fugiat irure. Sunt velit nostrud qui ullamco velit consequat in eu dolor eu exercitation laboris. Sit dolore quis sunt minim nostrud quis occaecat deserunt culpa dolor qui aliqua labore.</p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <div class="row">
        <div class="col-lg-6">
@include('admin.pages.includes.flash-message')

{!! Form::open(array('route' => 'admin.roles.store','method'=>'POST')) !!}
            <div class="form-group mb-4">
                <label>Role Name:</label>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
                </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">   
    
        <div class="form-group">
                <label>Permissions for this role:</label>
                
                <div class="form-cols">
                @foreach($permission as $value)
                    <div class="form-check mb-1">
                    {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                    <label class="form-check-label" for="{{ $value->id }}">
                    {{ $value->name }}
                    </label>
                    </div>
            @endforeach
            </div>
            </div>
    
            
            <button type="submit" class="btn mydir-button">Save</button>
        </div>
    </div>
{!! Form::close() !!}
   

<div class="row">
        <div class="col">
            <div class="mydir-controls mt-5">
                <a class="mydir-action" href="{{ route('admin.roles.index') }}"><i class="fas fa-caret-left mr-2"></i>Back</a>
            </div>
        </div>
    </div>
</div>
@endsection