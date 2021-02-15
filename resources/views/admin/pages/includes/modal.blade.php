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

        function modal_update_action_button_text(text){
			$('#confirm_modal #action_button').html(text);
        }

        function modal_remove_class_action_button_text(text){
			$('#confirm_modal #action_button').removeClass(text);
        }

        function modal_add_class_action_button_text(text){
			$('#confirm_modal #action_button').addClass(text);
        }

        function modal_update_data_id(text){
			$('#confirm_modal #data_id').html(text);
        }

        function modal_disable_action_button(){
			$('#confirm_modal #action_button').attr("disabled", true);
        }

        function modal_enable_action_button(){
			$('#confirm_modal #action_button').attr("disabled", false);
        }

        function modal_reset_class_action_button(){
            $('#confirm_modal #action_button').removeClass();
            $('#confirm_modal #action_button').addClass("btn btn-outline");
        }

		function modal_reset(){
			modal_update_processing_message("");
            modal_update_result_message("");
            modal_update_title("");
            modal_update_body("");
            modal_update_action_button_text("");
            modal_remove_class_action_button_text("btn-danger");
///            modal_remove_class_action_button_text("");
            modal_update_data_id("");
            modal_enable_action_button();

		}

		//closes the modal with a 1 seconds delay
		function modal_close(){
			setTimeout(function(){
				$('#confirm_modal').modal('hide');
                modal_reset();
                modal_enable_action_button();
			},2000);
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

		<!-- Form confirm (yes/ok) handler, submits form -->
		$('#confirm_modal').find('.modal-footer #action_button').on('click', function(){

		});

        $('#confirm_modal').find('.modal-footer #no_action_button').on('click', function(){

		});
    </script>
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
