@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Manage Vacancies Roles</h1>

    <p>Use the datagrid below to manage your vacancies roles. By default vacancies are ordered by the date they were added to the system.</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.vacancies.roles.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New vacancy role</a>
    </div>

    @include('admin.pages.includes.flash-message')

     <table id="vacancies_roles_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Vacancy Role</th>
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

        var table = $('#vacancies_roles_table').DataTable({
            processing: true,
            serverSide: true,

            searchDelay: 350,

            ajax: {
                url: "{{ route( Route::currentRouteName() ) }}",
            },

            columns: [
                {data: 'role', name: 'title', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false, @canany(['vacancy-delete'], 'admin') visible: true @else visible: false @endif },
            ],

        });

        //datatable filter triggered on return
        $('#vacancies_roles_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

    });



    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Vacancy Role?');
        modal_update_body("Are you sure you want to delete this vacancy role?");
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
            url: 'vacancies/roles/'+$('#data_id').text(),
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
</script>
@endpush
