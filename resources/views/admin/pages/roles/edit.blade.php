@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8 margin-tb">
        
            <h1 class="mb-4">Edit Role</h1>
            <p class="mydir-instructions">Edit the role name and the associated permissions.</p>
            
        </div>
    </div>
    <div class="row">
        <div class="col-12 border-bottom md-border my-4"></div>
    </div>

    <div class="row">
        <div class="col-lg-6">
        @include('admin.pages.includes.flash-message')

            {!! Form::model($role, ['method' => 'PATCH','route' => ['admin.roles.update', $role->id]]) !!}

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
                    {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                    
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