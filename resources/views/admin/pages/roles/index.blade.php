@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Role Management</h1>

    <p>Listed below are the admin role types held within the system.</p>

<div class="mydir-controls my-4">
@can('role-create')<a href="{{ route('admin.roles.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New Role</a> @endcan
    </div>

@include('admin.pages.includes.flash-message')

<table class="table table-bordered datatable mydir-table">
  <tr>
     <th>Name</th>
     <th>Action</th>
  </tr>
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ $role->name }}</td>
        <td>
            @can('role-edit')
                <a class="edit mydir-dg btn" href="{{ route('admin.roles.edit',$role->id) }}">Edit</a>
            @endcan
            {{-- @can('role-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['admin.roles.destroy', $role->id],'style'=>'display:inline']) !!}
                    {!! Form::submit('Delete', ['class' => 'open-delete-modal mydir-dg btn']) !!}
                {!! Form::close() !!}
            @endcan --}}
        </td>
    </tr>
    @endforeach
</table>

{!! $roles->render() !!}

@endsection
