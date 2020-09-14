tinymce.init({
	selector: 'textarea.tiny',
	plugins: [
		'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
		'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		'save table contextmenu directionality emoticons template paste textcolor'
	],
	file_browser_callback: function(field_name, url, type, win) {
		tinyMCE.activeEditor.windowManager.open({
			file: '/file-manager/tinymce',
			title: 'Laravel File Manager',
			width: window.innerWidth * 0.8,
			height: window.innerHeight * 0.8,
			resizable: 'yes',
			close_previous: 'no',
		}, {
			setUrl: function(url) {
				win.document.getElementById(field_name).value = url;
			},
		});
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