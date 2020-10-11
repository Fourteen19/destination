@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    
    <h2 class="mb-4">{{ __('ck_admin.manage_users.title') }}</h2>
    
    <p>{{ __('ck_admin.manage_users.instructions') }}</p>
    
    @include('admin.pages.includes.modal')

    <a href="{{ route('admin.users.create') }}">New user</a>

    @include('admin.pages.includes.flash-message')
    
    
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Custom Filter [Case Sensitive]</h3>
        </div>
        <div class="panel-body">
            <form method="POST" id="search-form" class="form-inline" role="form">
    
                <div class="flex flex-col justify-around h-full">
                    @livewire('admin.client-institution-dropdown', ['client' => '', 'institution' => ''])
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="search name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="search email">
                </div>
    
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        </div>
    </div>

    <table id="user_table" class="table table-bordered datatable">
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
            ajax: {
            url: "{{ route('admin.users.index') }}",
                data: function (d) {
                    d.name = $('input[name=name]').val();
                    d.email = $('input[name=email]').val();
                }
            },
            columns: [
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'email', name: 'email', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    

    $('#search-form').on('submit', function(e) {
        console.log("wwww");
        oTable.draw();
        e.preventDefault();
        
    });

});

/*
    $(function () {
        
        var table = $('#user_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.users.index') }}",
            columns: [
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });   

    });
*/

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

                if (data.error == true)
                {
                    message = "Your user could not be deleted";
                } else {
                    message = "User Deleted";
                }
                
                modal_update_result_message(message);
  
                if (data.error == false)
                {
                    $('#user_table').DataTable().ajax.reload();
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
       
    
</script>
@endpush