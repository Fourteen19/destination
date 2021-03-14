@push('scripts')
    <script type="text/javascript" src="{{ asset('admin/js/pages/include/modal.js')}}"></script>
@endpush

<!-- Modal Dialog -->
<div class="modal modal-warning fade in" id="confirm_modal" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fas fa-times"></i></span></button>

      </div>
      <div class="modal-body">
      <h4 class="modal-title">Modal Title</h4>
        <p>Body Text</p>
		<span id="modal_processing"></span>
        <span id="modal_result"></span>
        <span id="data_id" style="display:none"></span>
        <span id="data_id2" style="display:none"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" id="no_action_button" data-dismiss="modal">No</button>
        <button type="button" id="action_button" class="btn btn-outline">Yes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
