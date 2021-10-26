@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">

<h1 class="mb-4">My Institutions</h1>

    <p>The table below lists the institutions setup for this client.</p>

    @include('admin.pages.includes.modal')

    @include('admin.pages.includes.flash-message')

    <table id="my_institutions_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Name</th>
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

        var table = $('#my_institutions_table').DataTable({
            processing: true,
            serverSide: true,
            //, [ 'client' => $clientUuid ]
            ajax: "{{ route('admin.my-institutions.index') }}",
            columns: [
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            'columnDefs': [{
                className:'action-width',
                targets: [1]
            }]
        });

        //datatable filter triggered on return
        $('#my_institution_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            oTable.draw();
            e.preventDefault();
        });

    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.fn.dataTable.ext.errMode = () => alert(' @lang('ck_admin.datatables.loading_error') ');

</script>
@endpush
