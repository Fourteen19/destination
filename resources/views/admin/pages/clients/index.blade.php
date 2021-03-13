@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

<h1 class="mb-4">{{ __('ck_admin.manage_clients.title') }}</h1>

    <p>{{ __('ck_admin.manage_clients.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.clients.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New client</a>
    </div>


    @include('admin.pages.includes.flash-message')

     <table id="client_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Subdomain</th>
                <th>Action</th>
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

        var table = $('#client_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.clients.index') }}",
            columns: [
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'subdomain', name: 'subdomain', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });



    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Client?');
        modal_update_body("Are you sure you want to delete this client?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-suspend-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Suspend");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('suspend');
        modal_update_title('Suspend this client?');
        modal_update_body("Are you sure you want to suspend this client?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-unsuspend-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Unsuspend");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('unsuspend');
        modal_update_title('Unsuspend this client?');
        modal_update_body("Are you sure you want to unsuspend this client?");
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
            url: 'clients/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#client_table').DataTable().ajax.reload();
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


    $('.modal-footer').on('click', '.suspend', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'clients/'+$('#data_id').text()+'/suspend',
            data: {
                '_method' : 'PATCH',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                $('#suspend_'+$('#data_id').text()).text('Unsuspend');
                $('#suspend_'+$('#data_id').text()).addClass('open-unsuspend-modal');
                modal_remove_class_action_button_text('suspend');

                if (data.result)
                {
                    $('#client_table').DataTable().ajax.reload();

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

    $('.modal-footer').on('click', '.unsuspend', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'clients/'+$('#data_id').text()+'/unsuspend',
            data: {
                '_method' : 'PATCH',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                $('#suspend_'+$('#data_id').text()).text('Suspend');
                $('#suspend_'+$('#data_id').text()).addClass('open-suspend-modal');
                modal_remove_class_action_button_text('unsuspend');

                if (data.result)
                {
                    $('#client_table').DataTable().ajax.reload();

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
