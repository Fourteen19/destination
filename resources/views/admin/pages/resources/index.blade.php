@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <h1 class="mb-4">Teaching Resources</h1>

    <p>Here you will find all the teaching resources required to accompany the system and support your use of it within your school or college.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.resources.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New resource</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Resource Name</th>
                <th>Description</th>
                <th>Download Link</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@endsection