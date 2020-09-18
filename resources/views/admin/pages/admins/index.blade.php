@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    
    <h2 class="mb-4">{{ __('ck_admin.manage_sys_admin.title') }}</h2>
    
    <p>{{ __('ck_admin.manage_sys_admin.instructions') }}</p>
    
    @include('admin.pages.includes.modal')

    <table id="user_table" class="table table-bordered datatable">
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
        
        var table = $('#user_table').DataTable({
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


    $(document).on('click', '.open-delete-modal', function() {       
        $('#confirm_modal .actionBtn').text("Delete");
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete User?');
        $('.modal-body p').text("Are you sure you want to delete this user?");
        $('#data_id').text($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.modal-footer').on('click', '.delete', function() {
       
        $('#confirm_modal #modal_processing').text("Processing...");
       
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
                    message = "Your User could not be Deleted";
                } else {
                    message = "User Deleted";
                }
                
                modal_update_result_message(message);
                                
                if (data.error == false)
                {
                    $('#user_table').DataTable().ajax.reload();
                } else {
                    
                }

                setTimeout(function(){
                    reset_modal();
                }, 2000);
            },
            error: function(data) {
                modal_update_result_message("An error occured. Please try again later");
            }
        });


    });
    
    function reset_modal(){
        
    }
   
    
</script>
@endpush