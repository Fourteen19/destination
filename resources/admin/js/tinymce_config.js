tinymce.init({
    selector: 'textarea.tiny',
	plugins: [
		'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
		'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media image nonbreaking',
		'save table directionality emoticons template paste'
    ],
    relative_urls: false,
	file_picker_callback (callback, value, meta) {
        let x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth
        let y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight

        tinymce.activeEditor.windowManager.openUrl({
          url : '/file-manager/tinymce5',
          title : 'Laravel File manager',
          width : x * 0.8,
          height : y * 0.8,
          onMessage: (api, message) => {
            callback(message.content, { text: message.text })
          }
        })
    },
	setup: function(ed) {

		var allowedKeys = [8, 37, 38, 39, 40, 46]; // backspace, delete and cursor keys

        var maxlength = parseInt($('#'+(ed.id)).attr("maxlength"));


        if (maxlength > 0){

	        ed.on('keydown', function (e) {
	            if (allowedKeys.indexOf(e.keyCode) != -1) return true;
	            if (tinymce_getContentLength() + 1 > maxlength) {
	                e.preventDefault();
	                e.stopPropagation();
	                return false;
	            }
	            return true;
	        });

	        ed.on('keyup', function (e) {
	            tinymce_updateCharCounter(this, tinymce_getContentLength(), maxlength);
            });

    	}

    },

    init_instance_callback: function () { // initialize counter div
        var maxlength = parseInt($('#'+tinymce.activeEditor.id).attr("maxlength"));

        if (maxlength > 0){
        	$('#' + this.id).prev().append('<div class="char_count" style="text-align:right"></div>');
        	tinymce_updateCharCounter(this, tinymce_getContentLength(), maxlength);
        }
    },

    onchange_callback : "myCustomOnChangeHandler",

    paste_preprocess: function (plugin, args) {
        var editor = tinymce.get(tinymce.activeEditor.id);
		var maxlength = parseInt($('#'+tinymce.activeEditor.id).attr("maxlength"));
        var len = editor.contentDocument.body.innerText.length;
        var text = args.content;

		new_length = parseInt(len + text.length);
        if (new_length > maxlength) {
            alert('Pasting this exceeds the maximum allowed number of ' + maxlength + ' characters.');
            args.content = '';
        } else {
            tinymce_updateCharCounter(editor, len + text.length, maxlength);
        }
    }

});

function tinymce_updateCharCounter(el, len, maxlength) {
    $('#' + el.id).prev().find('.char_count').text(len + ' characters out of ' + maxlength + ' allowed');
}

function tinymce_getContentLength() {
    return tinymce.get(tinymce.activeEditor.id).contentDocument.body.innerText.length;
}

function myCustomOnChangeHandler(){
    console.log(el.id);
}
