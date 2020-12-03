@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">{{ __('ck_admin.manage_contents.title') }}</h2>

    <p>{{ __('ck_admin.manage_contents.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <a href="{{ route('admin.contents.create') }}">New content</a>

    @include('admin.pages.includes.flash-message')

     <table id="content_table" class="table table-bordered datatable">
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
            ajax: "{{ route('admin.contents.index') }}",
            columns: [
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

    });


    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete User?');
        modal_update_body("Are you sure you want to delete this content?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-make-live-modal', function() {
        modal_update_action_button_text("Make Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('make-live');
        modal_update_title('Make this content live?');
        modal_update_body("Are you sure you want to make this content live?");
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



    $('.modal-footer').on('click', '.make-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/make-live/'+$('#data_id').text(),
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.error == true)
                {
                    message = "Your content could not be made live";
                } else {
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

</script>
@endpush
