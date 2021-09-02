@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">User Batch Transfer</h1>

    <p>This screen allows the transfer of users between institutions. Note that some (larger) transfers do not always happen instantaneously and must be processed. You will receive an email notifaction once the transfer is complete.</p>
    <ol>
        <li>Begin by first selecting the institution and year group you wish to transfer from.</li>
        <li>Select the user(s) from the available list.</li>
        <li>Finally set the institution you wish to transfer to.</li>
    </ol>
    <div class="grey-line"></div>

    @include('admin.pages.includes.modal')

    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-sign-out-alt mr-3"></i>Step 1: Select the institution and year group you wish to transfer from</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    {{-- if client admin level --}}
                    @if (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.datatable-user-batch-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y', 'action' => 'transfer'])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-user-batch-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y', 'action' => 'transfer'])
                    @endif

                </form>
            </div>
        </div>

    @endif
    <div class="grey-line"></div>

    <h3 class="panel-title"><i class="nav-icon fas fa-user-check mr-3"></i>Step 2: Select the user(s) to be transferred</h3>

    <div class="checkbox check_all_students_wrap">
    <label for="check_all_students" class="select-all-label"><input type="checkbox" id="check_all_students" data-to-table="tasks" class="mr-2">Select All Users</label>
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

    <div class="grey-line"></div>

    {{-- if NOT advisor level --}}
    @if (session()->get('adminAccessLevel') != 1)

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fas fa-sign-in-alt nav-icon mr-3"></i>Step 3: Set the institution you wish to transfer the user(s) to</h3>
            </div>
            <div class="panel-body">

                {{-- if client admin level --}}
                @if (session()->get('adminAccessLevel') == 2)
                    @livewire('admin.datatable-user-transfer', ['institution' => session()->get('institution_filter'), 'displayTransferButton' => 'N'])

                {{-- if system admin level --}}
                @elseif (session()->get('adminAccessLevel') == 3)
                    @livewire('admin.datatable-user-transfer', ['institution' => session()->get('institution_filter'), 'displayTransferButton' => 'N'])
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
                url: "{{ route('admin.users.batch-transfer') }}",
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


        window.livewire.on('reset_filter', state => {
            oTable.draw();
            e.preventDefault();
        })


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
            modal_update_action_button_text("Transfer");
            modal_add_class_action_button_text('btn-danger');
            modal_add_class_action_button_text('transfer');
            modal_update_title('Transfer Users?');
            modal_update_body("Are you sure you want to transfer the selected users?");
            modal_update_data_id( get_users() );
            $('#confirm_modal').modal('show');
        });


        $('.modal-footer').on('click', '.transfer', function() {
            modal_close()
            Livewire.emit('transfer_users');
        });

    });

</script>
@endpush
