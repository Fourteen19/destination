@push('scripts')
    <!-- Dialog show event handler -->
    <script type="text/javascript">
      
		function modal_update_processing_message(text){
			$('#confirm_modal #modal_processing').html(text);
		}
	          
		function modal_update_result_message(text){
			$('#confirm_modal #modal_result').html(text);
		}
		
		function modal_reset(){
			modal_update_processing_message("");
			modal_update_result_message("");
		}
		
		//closes the modal with a 1 seconds delay
		function modal_close_window(){
			
			setTimeout(function(){
				$('#confirm_modal').modal('hide');
				modal_reset();
			},1000);
		}
		
		$('#confirm_modal').on('show.bs.modal', function (e) {
			$message = $(e.relatedTarget).attr('data-message');
			$(this).find('.modal-body p').text($message);
			$title = $(e.relatedTarget).attr('data-title');
			$(this).find('.modal-title').text($title);
			// Pass form reference to modal for submission on yes/ok
			var form = $(e.relatedTarget).closest('form');
			$(this).find('.modal-footer #confirm').data('form', form);
		});
		<!-- Form confirm (yes/ok) handler, submits form -->
		$('#confirm_modal').find('.modal-footer #confirm').on('click', function(){
			$(this).data('form').submit();
		});
		
    </script>
@endpush

<!-- Modal Dialog -->
<div class="modal modal-warning fade in" id="confirm_modal" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Warning Modal</h4>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
		<span id="modal_processing"></span>
		<span id="modal_result"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-outline" id="confirm">Yes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>