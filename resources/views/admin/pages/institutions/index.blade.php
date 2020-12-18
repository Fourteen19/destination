@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    
<h1 class="mb-4">{{ __('ck_admin.manage_clients_institutions.title') }}</h1>
    
    <p>{{ __('ck_admin.manage_clients_institutions.instructions') }}</p>

    @include('admin.pages.includes.modal')

    <div class="mydir-controls my-4">
    <a href="{{ route('admin.clients.institutions.create', ['client' => $clientUuid]) }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New institution</a>
    </div>
    

    @include('admin.pages.includes.flash-message')
    
    <table id="client_institution_table" class="table table-bordered datatable mydir-table">
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
        
        var table = $('#client_institution_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.clients.institutions.index', [ 'client' => $clientUuid ]) }}",
            columns: [
                {data: 'name', name: 'name', orderable: true, searchable: true},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });   

    });


    $(document).on('click', '.open-delete-modal', function() {       
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete institution?');
        modal_update_body("Are you sure you want to delete this institution?");
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
            url: 'clients/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                if (data.error == true)
                {
                    message = "Your institution could not be deleted";
                } else {
                    message = "Institution Deleted";
                }
                
                modal_update_result_message(message);
  
                if (data.error == false)
                {
                    $('#client_institution_table').DataTable().ajax.reload();
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