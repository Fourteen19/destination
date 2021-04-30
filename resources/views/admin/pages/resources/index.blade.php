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

     <table id="resources_table" class="table table-bordered datatable mydir-table">
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


@push('scripts')
<script type="text/javascript">


    $(function () {

        var table = $('#resources_table').DataTable({
            processing: true,
            serverSide: true,

            //searchDelay: 350,

            ajax: {
                url: "{{ route( Route::currentRouteName() ) }}",
                data: function (d) {
                    d.type = $('#type').val();
                }
            },

            columns: [
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'description', name: 'description', orderable: false, searchable: false},
                {data: 'link', name: 'link', orderable: false, searchable: false},
                {data: 'client', name: 'client', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        //datatable filter triggered on return
        $('#resources_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

    });

</script>
@endpush
