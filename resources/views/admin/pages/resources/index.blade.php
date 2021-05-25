@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Teaching Resources</h1>

    <p>Here you will find all the teaching resources required to accompany the system and support your use of it within your school or college.</p>

    @include('admin.pages.includes.modal')

    @can('role-create', 'admin')
        <div class="mydir-controls my-4">
            <a href="{{ route('admin.resources.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New resource</a>
        </div>
    @endcan

    @include('admin.pages.includes.flash-message')

     <table id="resources_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Resource Name</th>
                <th>Description</th>
                <th>Link</th>
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

            searchDelay: 350,

            ajax: {
                url: "{{ route( Route::currentRouteName() ) }}",
                data: function (d) {
                    d.type = $('#type').val();
                }
            },

            columns: [
                {data: 'filename', name: 'filename', orderable: true, searchable: true},
                {data: 'description', name: 'description', orderable: false, searchable: false},
                {data: 'link', name: 'link', orderable: false, searchable: false},
                {data: 'client', name: 'client', orderable: false, searchable: false, @if (isGlobalAdmin()) visible: true @else visible: false @endif },
                {data: 'action', name: 'action', orderable: false, searchable: false, @canany(['resource-edit', 'resource-delete'], 'admin') visible: true @else visible: false @endif },
            ],
            'columnDefs': [{
                className:'action-width',
                targets: [1,4]
            }]

        });

        //datatable filter triggered on return
        $('#resources_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

    });



    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Resource?');
        modal_update_body("Are you sure you want to delete this resource?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $('.modal-footer').on('click', '.delete', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'resources/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#resources_table').DataTable().draw(false);

                }
            },
            error: function(data) {
                modal_update_result_message("An error occured. Please try again later");
            },
            complete: function(data) {

                modal_close()

            }
        });

    });
</script>
@endpush
