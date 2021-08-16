@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Manage Passed Vacancies</h1>

    <p>Use the datagrid below to manage your passed vacancies. By default vacancies are ordered by the date they were added to the system.</p>

    @include('admin.pages.includes.modal')

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
                {data: 'client', name: 'client', orderable: false, searchable: false, @if ( (isGlobalAdmin()) || (adminHasRole(Auth::guard('admin')->user(), config('global.admin_user_type.Employer') ) ) )visible: true @else visible: false @endif },
                {data: 'action', name: 'action', orderable: false, searchable: false, @canany(['vacancy-edit', 'vacancy-delete'], 'admin') visible: true @else visible: false @endif },
            ],

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

</script>
@endpush
