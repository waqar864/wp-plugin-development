jQuery(document).ready(function($) {         //wrapper
	$("#get_total_books").on('click', function() {
        $.post(pluginprefix_ajax_object.ajax_url, {      //POST request
			_ajax_nonce: pluginprefix_ajax_object.nonce, //nonce
			action: "pluginprefix_ajax_example",         //action
			// title: this.value               //data
			}, function(data) {            //callback
				// this2.nextSibling.remove(); //remove current title
				// $(this2).after(data);       //insert server response
                // alert(data);
                $("#books_response").html(data); //display response in the paragraph
			}
		);
    });
} );