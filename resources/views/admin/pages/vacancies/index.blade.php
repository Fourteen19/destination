@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
    <h1 class="mb-4">Manage Vacancies</h1>

    <p>Use the datagrid below to manage your vacancies. By default vacncies are ordered by the date they were added to the system.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.vacancies.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New vacancy</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Vacancy Title</th>
                <th>Global</th>
                <th>Client</th>
                <th>Employer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example row -->
            <tr>
                <td>[VACANCY TITLE]</td>
                <td>[Y] or blank</td>
                <td>[CLIENT NAME] or blank if global</td>
                <td>[EMPLOYER NAME]</td>
                <td>[EDIT] | [MAKE / REMOVE LIVE] | [DELETE]</td>
            </tr>
        </tbody>
    </table>
</div>


@endsection
