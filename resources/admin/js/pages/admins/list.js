$(function () {

    // DataTable
    var oTable = $('#admin_table').DataTable({
        processing: true,
        serverSide: true,

        searchDelay: 350,
        deferLoading: 0,

        ajax: {
            url: "/admin/admins",
            data: function (d) {
                d.institution = $('#institution').val();
                d.role = $('#role').val();
            }
        },

        columns: [
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email',  orderable: false, searchable: false},
            { data: 'role', name: 'role.name', orderable: false, searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    //datatable filter triggered on return
    $('#admin_table').dataTable().fnFilterOnReturn();

    $('#search-form').on('submit', function(e) {
        oTable.draw();
        e.preventDefault();
    });

});



$(document).on('click', '.open-delete-modal', function() {
    modal_update_action_button_text("Delete");
    modal_add_class_action_button_text('btn-danger');
    modal_add_class_action_button_text('delete');
    modal_update_title('Delete Adminitrator?');
    modal_update_body("Are you sure you want to delete this adminitrator?");
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
        url: 'admins/'+$('#data_id').text(),
        data: {
            '_method' : 'DELETE',
        },
        dataType: 'json',
        success: function(data) {

            modal_update_result_message(data.message);

            if (data.result)
            {
                $('#admin_table').DataTable().draw(false);

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
