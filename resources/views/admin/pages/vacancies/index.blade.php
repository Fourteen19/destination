@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Manage Vacancies</h1>

    <p>Use the datagrid below to manage your vacancies. By default vacancies are ordered by the date they were added to the system.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.vacancies.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New vacancy</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="vacancies_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Vacancy Title</th>
                <th>Employer</th>
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

        var table = $('#vacancies_table').DataTable({
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
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'employer', name: 'employer', orderable: false, searchable: false},
                {data: 'client', name: 'client', orderable: false, searchable: false, @if (isGlobalAdmin()) visible: true @else visible: false @endif },
                {data: 'action', name: 'action', orderable: false, searchable: false, @canany(['vacancy-edit', 'vacancy-make-live', 'vacancy-delete'], 'admin') visible: true @else visible: false @endif },
            ],

            /* columnDefs: [ {
                "targets": 1,
                "width": "500"
            } ], */

        });

        //datatable filter triggered on return
        $('#vacancies_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

    });



    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Vacancy?');
        modal_update_body("Are you sure you want to delete this vacancy?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });


    $(document).on('click', '.open-make-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Make Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('make-live');
        modal_update_title('Make this vacancy live?');
        modal_update_body("Are you sure you want to make this vacancy live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-apply-latest-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Apply latest changes to Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('apply-latest-live');
        modal_update_title('Apply latest changes from this vacancy to live?');
        modal_update_body("Are you sure you want to apply the latest changes from this vacancy to live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-remove-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Remove from Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('remove-live');
        modal_update_title('Remove this vacancy from live?');
        modal_update_body("Are you sure you want to remove this vacancy from live?");
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
            url: 'vacancies/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#vacancies_table').DataTable().draw(false);

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
            url: 'vacancies/'+$('#data_id').text()+'/make-live',
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




    $('.modal-footer').on('click', '.apply-latest-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'vacancies/'+$('#data_id').text()+'/make-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).remove();
                    modal_remove_class_action_button_text('apply-latest-live');

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


    $('.modal-footer').on('click', '.remove-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'vacancies/'+$('#data_id').text()+'/remove-live',
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
