@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    
    <h2 class="mb-4">{{ __('ck_admin.manage_sys_admin.title') }}</h2>
    
    <p>{{ __('ck_admin.manage_sys_admin.instructions') }}</p>
    
    @include('admin.pages.includes.modal')

    <table class="table table-bordered yajra-datatable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
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
        
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.admins.index') }}",
            columns: [
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'email', name: 'email', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script>
@endpush