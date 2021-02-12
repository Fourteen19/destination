@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_contents.title', ['content_type' => $contentOwner ]) }}</h1>

    <p>{{ __('ck_admin.manage_contents.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.contents.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New content</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Title</th>
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

        var table = $('#content_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route( Route::currentRouteName() ) }}",
            columns: [
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });


    $(document).on('click', '.open-delete-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete User?');
        modal_update_body("Are you sure you want to delete this content?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-make-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Make Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('make-live');
        modal_update_title('Make this content live?');
        modal_update_body("Are you sure you want to make this content live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-remove-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Remove from Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('remove-live');
        modal_update_title('Remove this content from live?');
        modal_update_body("Are you sure you want to remove this content from live?");
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
            url: 'contents/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                if (data.error == true)
                {
                    message = "Your content could not be deleted";
                } else {
                    message = "Content Deleted";
                }

                modal_update_result_message(message);

                if (data.error == false)
                {
                    $('#content_table').DataTable().draw();
                } else {

                }
            },
            error: function(data) {
                modal_update_result_message("An error occured. Please try again later");
            },
            complete: function(data) {

                modal_close();

            }
        });

    });



    $('.modal-footer').on('click', '.make-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/'+$('#data_id').text()+'/make-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.error == true)
                {
                    message = "Your content could not be made live";
                } else {
                    $('#live_'+$('#data_id').text()).text('Remove from Live');
                    $('#live_'+$('#data_id').text()).addClass('open-remove-live-modal');
                    modal_remove_class_action_button_text('make-live');
                    message = "Content Made Live";
                }

                modal_update_result_message(message);

                if (data.error == false)
                {
                    $('#content_table').DataTable().ajax.reload();

                } else {

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




    $('.modal-footer').on('click', '.remove-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/'+$('#data_id').text()+'/remove-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.error == true)
                {
                    message = "Your content could not be removed from live";
                } else {
                    $('#live_'+$('#data_id').text()).text('Make Live');
                    $('#live_'+$('#data_id').text()).removeClass('open-remove-live-modal');
                    $('#live_'+$('#data_id').text()).addClass('open-make-live-modal');
                    modal_remove_class_action_button_text('remove-live');
                    message = "Content Removed from Live";
                }

                modal_update_result_message(message);

                if (data.error == false)
                {
                    $('#content_table').DataTable().ajax.reload();

                } else {

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
