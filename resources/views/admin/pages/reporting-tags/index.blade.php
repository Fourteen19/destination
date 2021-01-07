@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    
    <h1 class="mb-4">Manage Reporting Tags</h1>

    <p>Use the datagrid below to manage the reporting tags held within your system.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.client-reporting-tags.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New Reporting Tag</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Tag Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>[CLIENT REPORTING TAG NAME]</td>
                <td>[EDIT] | [MAKE / REMOVE LIVE] | [DELETE]</td>
            </tr>
        </tbody>
    </table>
</div>


@endsection
