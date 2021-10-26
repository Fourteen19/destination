$(document).on('click', '.open-delete-modal', function() {
    modal_update_action_button_text("Delete");
    modal_add_class_action_button_text('btn-danger');
    modal_add_class_action_button_text('delete');
    modal_update_title('Delete User?');
    modal_update_body("Are you sure you want to delete this user?");
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
        url: 'users/'+$('#data_id').text(),
        data: {
            '_method' : 'DELETE',
        },
        dataType: 'json',
        success: function(data) {

            modal_update_result_message(data.message);

            if (data.result){
                $('#user_table').DataTable().draw(false);
            }
        },
        error: function(data) {
            modal_update_result_message("An error occured. Please try again later");
        },
        complete: function(data) {

            modal_close()

        }
    });

    $.fn.dataTable.ext.errMode = () => alert(' @lang('ck_admin.datatables.loading_error') ');

});
