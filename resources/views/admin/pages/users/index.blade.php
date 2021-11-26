@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

    <h1 class="mb-4">Manage Users</h1>

    <p>The table below lists the users for the selected institution (that belongs to the selected client above). Use the filter to change institution and the keyword search to find a user by name.</p>

    @include('admin.pages.includes.modal')

    @can('user-create', 'admin')
        <div class="mydir-controls my-4">
            <a href="{{ route('admin.users.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New User</a>
        </div>
    @endcan

    @include('admin.pages.includes.flash-message')

    {{-- if NOT advisor level --}}
    {{-- @if (session()->get('adminAccessLevel') != 1) --}}

    @if ( (adminHasRole(Auth::guard('admin')->user(), config('global.admin_user_type.Advisor')) ) || (session()->get('adminAccessLevel') == 2) || (session()->get('adminAccessLevel') == 3)  )

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter users</h3>
            </div>
            <div class="panel-body">
                <form method="POST" id="search-form" role="form">

                    @if (  adminHasRole(Auth::guard('admin')->user(), config('global.admin_user_type.Advisor')) )
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])

                    {{-- if client admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 2)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])

                    {{-- if system admin level --}}
                    @elseif (session()->get('adminAccessLevel') == 3)
                        @livewire('admin.datatable-institution-filter', ['institution' => session()->get('institution_filter'), 'displaySearchButton' => 'Y'])
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
<script src="{{ asset('admin/js/pages/users/list.js')}}"></script>

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
            ],
            'columnDefs': [{
                className:'action-width',
                targets: [2]
            }]
        });

        //datatable filter triggered on return
        $('#user_table').dataTable().fnFilterOnReturn();

        $.fn.dataTable.ext.errMode = () => alert(' @lang('ck_admin.datatables.loading_error') ');

        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

        @if (!empty(session()->get('institution_filter')))
            oTable.draw();
        @endif

    });

</script>
@endpush
