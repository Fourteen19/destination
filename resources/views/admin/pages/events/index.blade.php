@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <h1 class="mb-4">Manage Events</h1>

    <p>Use the datagrid below to manage your events. By default events are ordered by the date they are due to take place.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.events.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New event</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Event Title</th>
                <th>Event Date</th>
                <th>Global</th>
                <th>Client</th>
                <th>Institution</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>[EVENT TITLE]</td>
                <td>[EVENT DATE]</td>
                <td>[Y] or blank</td>
                <td>[CLIENT NAME] or blank if global</td>
                <td>[INSTITUTION NAME] only if set by adviser</td>
                <td>[EDIT] | [MAKE / REMOVE LIVE] | [DELETE]</td>
            </tr>
            
            
        </tbody>
    </table>
</div>

@endsection
