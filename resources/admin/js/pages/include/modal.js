
    modal_update_processing_message = function modal_update_processing_message(text){
        $('#confirm_modal #modal_processing').html(text);
    }

    modal_update_result_message = function modal_update_result_message(text){
        $('#confirm_modal #modal_result').html(text);
    }

    modal_update_title = function modal_update_title(text){
        $('#confirm_modal .modal-title').html(text);
    }

    modal_update_body = function modal_update_body(text){
        $('#confirm_modal .modal-body p').html(text);
    }

    modal_update_action_button_text = function modal_update_action_button_text(text){
        $('#confirm_modal #action_button').html(text);
    }

    modal_remove_class_action_button_text = function modal_remove_class_action_button_text(text){
        $('#confirm_modal #action_button').removeClass(text);
    }

    modal_add_class_action_button_text = function modal_add_class_action_button_text(text){
        $('#confirm_modal #action_button').addClass(text);
    }

    modal_update_data_id = function modal_update_data_id(text){
        $('#confirm_modal #data_id').html(text);
    }

    modal_update_data_id2 = function modal_update_data_id2(text){
        $('#confirm_modal #data_id2').html(text);
    }

    modal_disable_action_button = function modal_disable_action_button(){
        $('#confirm_modal #action_button').attr("disabled", true);
    }

    modal_enable_action_button = function modal_enable_action_button(){
        $('#confirm_modal #action_button').attr("disabled", false);
    }

    modal_reset_class_action_button = function modal_reset_class_action_button(){
        $('#confirm_modal #action_button').removeClass();
        $('#confirm_modal #action_button').addClass("btn btn-outline");
    }

    modal_reset = function modal_reset(){
        modal_update_processing_message("");
        modal_update_result_message("");
        modal_update_title("");
        modal_update_body("");
        modal_update_action_button_text("");
        modal_remove_class_action_button_text("btn-danger");
    ///            modal_remove_class_action_button_text("");
        modal_update_data_id("");
        modal_update_data_id2("");
        modal_enable_action_button();

    }

    //closes the modal with a 1 seconds delay
    modal_close = function modal_close(){
        setTimeout(function(){
            $('#confirm_modal').modal('hide');
            modal_reset();
            modal_enable_action_button();
        },2000);
    }

    $('#confirm_modal').on('show.bs.modal', function (e) {

    });

    $('#confirm_modal').find('.modal-footer #action_button').on('click', function(){

    });

    $('#confirm_modal').find('.modal-footer #no_action_button').on('click', function(){

    });


