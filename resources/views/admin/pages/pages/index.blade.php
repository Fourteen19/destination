@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="mb-4">Manage Public Site</h1>

    <p>Use the datagrid below to manage the pages in your public site.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.pages.standard.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New Public Page</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="page_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Page Title</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script type="text/javascript">


    $(function () {

        var table = $('#page_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route( Route::currentRouteName() ) }}",
            columns: [
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });

</script>
@endpush
