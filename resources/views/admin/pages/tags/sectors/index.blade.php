@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_tags.manage_sectors.title') }}</h1>

    <p>{{ __('ck_admin.manage_tags.manage_sectors.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.tags.sectors.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New sector tag</a>
    </div>

    @include('admin.pages.includes.flash-message')

    <table id="sectors_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
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

        var table = $('#sectors_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.tags.sectors.index') }}",
            columns: [
                {data: '#', name: '#', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: false, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        @canany(['client-tag-edit'], 'admin')
            $( "#sectors_table" ).sortable({
                items: "tr.row-item",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    updateOrder();
                }
            });
        @endcanany

        function updateOrder() {
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('tr.row-item').each(function(index,element) {
                order.push({
                    id: $(this).attr('data-id'),
                    position: index+1
                });
            });

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('admin.tags.sectors.reorder') }}",
                    data: {
                    order: order,
                    page: table.page(),
                    entries: table.page.len()
                },
                success: function(response) {

                }
            });
        }

    });


    $(document).on('click', '.open-delete-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Tag?');
        modal_update_body("Are you sure you want to delete this tag?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-make-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Make Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('make-live');
        modal_update_title('Make this content live?');
        modal_update_body("Are you sure you want to make this tag live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-remove-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Remove from Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('remove-live');
        modal_update_title('Remove this content from live?');
        modal_update_body("Are you sure you want to remove this tag from live?");
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
            url: 'tags/sectors/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#sectors_table').DataTable().ajax.reload();
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
            url: 'tags/sectors/'+$('#data_id').text()+'/make-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).text('Remove from Live');
                    $('#live_'+$('#data_id').text()).addClass('open-remove-live-modal');
                    modal_remove_class_action_button_text('make-live');
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
            url: 'tags/sectors/'+$('#data_id').text()+'/remove-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).text('Make Live');
                    $('#live_'+$('#data_id').text()).removeClass('open-remove-live-modal');
                    $('#live_'+$('#data_id').text()).addClass('open-make-live-modal');
                    modal_remove_class_action_button_text('remove-live');
                }

                modal_update_result_message(data.message);

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
