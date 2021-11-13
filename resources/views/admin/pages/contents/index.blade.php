@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <h1 class="mb-4">{{ __('ck_admin.manage_contents.title', ['content_type' => $contentOwner ]) }}</h1>

    <p>The table below lists the {{ $contentOwner }} content held on the system. The content is ordered by the last edited date.</p>

    @include('admin.pages.includes.modal')

    @if (strtolower(Request::segment(2)) == 'global')
        @can('global-content-create', 'admin')
            <div class="mydir-controls my-4">
                <a href="{{ route('admin.global.contents.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New content</a>
            </div>
        @elsecan('client-content-create', 'admin')
            <div class="mydir-controls my-4">
                <a href="{{ route('admin.contents.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New content</a>
            </div>
        @endcan
    @else
        @can('client-content-create', 'admin')
            <div class="mydir-controls my-4">
                <a href="{{ route('admin.contents.create') }}" class="mydir-action"><i class="fas fa-plus-square mr-2"></i>New content</a>
            </div>
        @endcan
    @endif


    @include('admin.pages.includes.flash-message')



    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="nav-icon fas fa-users mr-3"></i>Filter content</h3>
        </div>
        <div class="panel-body">
            <form method="POST" id="search-form" role="form">

                @livewire('admin.manage-content-filter')

            </form>
        </div>
    </div>


    <table id="content_table" class="table table-bordered datatable mydir-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Type</th>
                <th>Last Edited</th>
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

        var table = $('#content_table').DataTable({
            processing: true,
            serverSide: true,

            //searchDelay: 350,
            //deferLoading: 0,

            ajax: {
                url: "{{ route( Route::currentRouteName() ) }}",
                data: function (d) {
                    d.type = $('#type').val();
                }
            },

            columns: [
                {data: 'title', name: 'title', orderable: true, searchable: true},
                {data: 'type', name: 'type', orderable: false, searchable: false},
                {data: 'lastedited', name: 'lastedited', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            'columnDefs': [{
                className:'action-width',
                targets: [3]
            }]
        });

        //datatable filter triggered on return
        $('#content_table').dataTable().fnFilterOnReturn();

        $('#search-form').on('submit', function(e) {
            table.draw();
            e.preventDefault();
        });

        $.fn.dataTable.ext.errMode = () => alert(' @lang('ck_admin.datatables.loading_error') ');

    });


    $(document).on('click', '.open-delete-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Delete");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('delete');
        modal_update_title('Delete Content?');
        modal_update_body("Are you sure you want to delete this content?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-make-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Make Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('make-live');
        modal_update_title('Make this content live?');
        modal_update_body("Are you sure you want to make this content live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-apply-latest-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Apply latest changes to Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('apply-latest-live');
        modal_update_title('Apply latest changes from this content to live?');
        modal_update_body("Are you sure you want to apply the latest changes from this content to live?");
        modal_update_data_id($(this).data('id'));
        $('#confirm_modal').modal('show');
    });

    $(document).on('click', '.open-remove-live-modal', function() {
        modal_reset_class_action_button();
        modal_update_action_button_text("Remove from Live");
        modal_add_class_action_button_text('btn-danger');
        modal_add_class_action_button_text('remove-live');
        modal_update_title('Remove this content from live?');
        modal_update_body("Are you sure you want to remove this content from live?");
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
            url: 'contents/'+$('#data_id').text(),
            data: {
                '_method' : 'DELETE',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#content_table').DataTable().draw(false);
                }
            },
            error: function(data) {
                modal_update_result_message("An error occured. Please try again later");
            },
            complete: function(data) {

                modal_close();

            }
        });

    });



    $('.modal-footer').on('click', '.make-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/'+$('#data_id').text()+'/make-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                modal_update_result_message(data.message);

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).html('<i class="fas fa-times mr-1"></i><i class="fas fa-bolt"></i>');
                    $('#live_'+$('#data_id').text()).removeClass('open-make-live-modal');
                    $('#live_'+$('#data_id').text()).addClass('open-remove-live-modal');
                    modal_remove_class_action_button_text('make-live');
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




    $('.modal-footer').on('click', '.apply-latest-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/'+$('#data_id').text()+'/make-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).remove();
                    modal_remove_class_action_button_text('apply-latest-live');

                }

                modal_update_result_message(data.message);

            },
            error: function(data) {
                modal_update_result_message("An error occured. Please try again later");
            },
            complete: function(data) {

                modal_close()

            }
        });

        });


    $('.modal-footer').on('click', '.remove-live', function() {

        modal_update_processing_message("Processing...");
        modal_disable_action_button();

        $.ajax({
            type: 'POST',
            url: 'contents/'+$('#data_id').text()+'/remove-live',
            data: {
                '_method' : 'POST',
            },
            dataType: 'json',
            success: function(data) {

                if (data.result)
                {
                    $('#live_'+$('#data_id').text()).html('<i class="fas fa-check mr-1"></i><i class="fas fa-bolt"></i>');
                    $('#live_'+$('#data_id').text()).removeClass('open-remove-live-modal');
                    $('#live_'+$('#data_id').text()).addClass('open-make-live-modal');
                    modal_remove_class_action_button_text('remove-live');
                }

                modal_update_result_message(data.message);

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
