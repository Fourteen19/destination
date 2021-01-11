@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_sys_admins.title') }}</h1>

    <p>{{ __('ck_admin.manage_sys_admins.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.admins.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New admin</a>
    </div>

    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter administrators</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.client-institution-admin-type-filter', ['client' => session()->get('client')->uuid, 'institution' => ''])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.client-institution-admin-type-filter', ['client' => '', 'institution' => ''])
                    @endif

                </form>
            </div>
        </div>

    @endif

    <table id="admin_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
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

        // DataTable
        var oTable = $('#admin_table').DataTable({
            processing: true,
            serverSide: true,

            searchDelay: 350,
            deferLoading: 0,
            ajax: {
                url: "{{route('admin.admins.index')}}",
                data: function (d) {
                    d.client = $('#client').val();
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


/*
    $(document).on('click', '.open-delete-modal', function() {
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Adminitrator?');
        modal_update_body("Are you sure you want to delete this adminitrator?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });
*/
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
/*
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

                if (data.error == true)
                {
                    message = "Your admin could not be deleted";
                } else {
                    message = "Admin Deleted";
                }

                modal_update_result_message(message);

                if (data.error == false)
                {

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
*/

</script>
@endpush
