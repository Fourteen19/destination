@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_users.title') }}</h1>

    <p>{{ __('ck_admin.manage_users.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.users.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New User</a>
    </div>


    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter users</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter')])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter') ])
                    @endif

                </form>
            </div>
        </div>

    @endif


    <table id="user_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
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

        var oTable = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 350,
            @if (session()->get('adminAccessLevel') != 1)
                deferLoading: 0,
            @endif
            ajax: {
                url: "{{ route('admin.users.index') }}",
                data: function (d) {
                    d.institution = $('#institution').val();
                }
            },
            columns: [
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'email', name: 'email', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        //datatable filter triggered on return
        $('#user_table').dataTable().fnFilterOnReturn();


        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

        @if (!empty(session()->get('institution_filter')))
            oTable.draw();
        @endif

    });




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
                    $('#user_table').DataTable().ajax.reload();
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
