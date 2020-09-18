@push('scripts')
    <!-- Dialog show event handler -->
    <script type="text/javascript">
      
		function modal_update_processing_message(text){
			$('#confirm_modal #modal_processing').html(text);
		}
	          
		function modal_update_result_message(text){
			$('#confirm_modal #modal_result').html(text);
		}
        
        function modal_update_title(text){
			$('#confirm_modal .modal-title').html(text);
		}

        function modal_update_body(text){
			$('#confirm_modal .modal-body p').html(text);
		}

		function modal_reset(){
			modal_update_processing_message("");
            modal_update_result_message("");
            $('#confirm_modal .actionBtn').text("");
            $('.actionBtn').removeClass('btn-danger');
            $('.actionBtn').removeClass('delete');
            $('#data_id').text();
            $('#confirm_modal').modal('hide');
		}
		
		//closes the modal with a 1 seconds delay
		function modal_close_window(){
			
			setTimeout(function(){
				$('#confirm_modal').modal('hide');
				modal_reset();
			},1000);
		}
		
		$('#confirm_modal').on('show.bs.modal', function (e) {
           
/*            $message = $(e.relatedTarget).attr('data-message');
			$(this).find('.modal-body p').text($message);
            
            $title = $(e.relatedTarget).attr('data-title');
			$(this).find('.modal-title').text($title);
            
            // Pass form reference to modal for submission on yes/ok
			var form = $(e.relatedTarget).closest('form');
        	$(this).find('.modal-footer #modal_confirm_yes').data('form', form);
*/
        });
/*        
		<!-- Form confirm (yes/ok) handler, submits form -->
		$('#confirm_modal').find('.modal-footer #modal_confirm_yes').on('click', function(){          
            $(this).data('form').submit();
		});
*/		 
    </script>
@endpush

<!-- Modal Dialog -->
<div class="modal modal-warning fade in" id="confirm_modal" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Modal Title</h4>
      </div>
      <div class="modal-body">
        <p>Body Text</p>
		<span id="modal_processing"></span>
        <span id="modal_result"></span>
        <span id="data_id" style="display:none"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-outline actionBtn">Yes</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>