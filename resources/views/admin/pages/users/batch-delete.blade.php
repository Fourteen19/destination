@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">User Batch Delete</h1>

    <p>The table below lists the users for the selected institution (that belongs to the selected client above). Use the filter to change institution and the keyword search to find a user by name.</p>

    @include('admin.pages.includes.modal')

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
                        @livewire('admin.datatable-user-transfer-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-user-transfer-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])
                    @endif

                </form>
            </div>
        </div>

    @endif


    <div class="checkbox check_all_students_wrap">
        <input type="checkbox" id="check_all_students" data-to-table="tasks"><label>Select All</label>
    </div>

    <table id="user_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Select</th>
                <th>Name</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>



    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Delete</h3>
            </div>
            <div class="panel-body">

                {{-- if client admin level --}}
                @if (session()->get('adminAccessLevel') == 2)
                    @livewire('admin.datatable-user-delete', ['institution' => session()->get('institution_filter'), 'displayDeleteButton' => 'N'])

                {{-- if system admin level --}}
                @elseif (session()->get('adminAccessLevel') == 3)
                    @livewire('admin.datatable-user-delete', ['institution' => session()->get('institution_filter'), 'displayDeleteButton' => 'N'])
                @endif

            </div>
        </div>

    @endif


</div>
@endsection


@push('scripts')
<script type="text/javascript">

    $(function () {

        var oTable = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            searchDelay: 350,
            paging: false,
            @if (session()->get('adminAccessLevel') != 1)
                deferLoading: 0,
            @endif
            ajax: {
                url: "{{ route('admin.users.batch-delete') }}",
                data: function (d) {
                    d.institution = $('#institution').val();
                    d.year = $('#year').val();
                }
            },
            columns: [
                {data: 'select', name: 'select', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'email', name: 'email', orderable: true, searchable: true},
            ],
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


        window.livewire.on('reset_selectAll', state => {
            if (!state)
            {
                $('#check_all_students').prop('checked', false);
            }
        })


        function get_users()
        {
            allUsers = [];
            $('.chck:checked').each(function () {
                allUsers.push($(this).val());
            });
            livewire.emit('userAdded', allUsers, $("#institution").val());
        }

        $(document).on('change', '.chck', function(){
            get_users();
        });

        $('body').on('change', '#check_all_students', function() {
            var stud_row, checked;
            stud_row = $('#user_table').find('tbody tr');
            checked = $(this).prop('checked');
            $.each(stud_row, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
            });

            get_users();
        });



        $(document).on('click', '.open-delete-modal', function() {
            modal_update_action_button_text("Delete");
            modal_add_class_action_button_text('btn-danger');
            modal_add_class_action_button_text('delete');
            modal_update_title('Delete Users?');
            modal_update_body("Are you sure you want to delete the selected users?");
            modal_update_data_id( get_users() );
            $('#confirm_modal').modal('show');
        });


        $('.modal-footer').on('click', '.delete', function() {
            modal_close()
            Livewire.emit('delete_users');
        });

    });

</script>
@endpush
