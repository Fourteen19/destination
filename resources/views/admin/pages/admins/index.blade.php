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



/*
    //Triggered when `yes` is selected in the publish modal 
    $(".delete_form").submit(function(e)
    {
        
        //The default action of the event will not be triggered
        e.preventDefault();

        //compiles all form fields in an associative array
        form_data = get_form_data($(this));
        attributes = {
            form_data : form_data
        };

        //triggers the page action function
        page_action(attributes);
        
    });
*/



    $(document).on('click', '.delete', function(){
        user_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
    $.ajax({
        url:"sample/destroy/"+user_id,
        beforeSend:function(){
            $('#ok_button').text('Deleting...');
        },
        success:function(data)
        {
            setTimeout(function(){
            $('#confirmModal').modal('hide');
            $('#user_table').DataTable().ajax.reload();
            alert('Data Deleted');
            }, 2000);
        }
        })
    });

    });

</script>
@endpush