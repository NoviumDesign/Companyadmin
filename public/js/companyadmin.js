var userList = [];
var elem = $('input#customer');

elem.live('keydown keyup', function() {
	elem = $(this);	
	var value = elem.val();

    $.post(
    	'/ajax/customer',
		{'name': value},
		function(response){
			userList = response;

			appendUser();
    	},
    	'json'
    );
});

function appendUser() {
	elem.autocomplete({
		source: userList
	});
}

// set values and stuff
elem.live('autocompletechange autocompleteselect', function(event, ui) {
	setTimeout(function() {
		if(ui.item) {
			$('#customerId').val(ui.item.value);
			elem.val(ui.item.label);
		} else {
			$('#customerId').val('');
			elem.val('');
		}
	}, 0);
});

// make autocomplete events work for click
$('.ui-autocomplete').live('click', function() {
	elem.blur();
})