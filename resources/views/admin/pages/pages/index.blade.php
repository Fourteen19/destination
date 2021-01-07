@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    
    <h1 class="mb-4">Manage Public Site</h1>

    <p>Use the datagrid below to manage the pages in your public site.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.pages.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New Public Page</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Page Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>[PUBLIC PAGE TITLE]</td>
                <td>[EDIT] | [MAKE / REMOVE LIVE] | [DELETE]</td>
            </tr>
        </tbody>
    </table>
</div>


@endsection
