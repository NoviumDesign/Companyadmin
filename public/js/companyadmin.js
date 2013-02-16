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



//
// CLICK TABLE
//
$('.clickable').live('click', function(event) {
	// clicked child elements
	$target = $(event.target);
	$targetTd = $target.parent('td');

	// if target is link
	if($target.attr('href')) {
		// link via link
		return;
	}

	// if target contain link
	if($targetTd.data('link')) {
		// libk via td
		window.location = $targetTd.data('link');
		return;
	}

	// if parent td contain link
	if($(this).data('link')) {
		// libk via td
		window.location = $(this).data('link');
		return;
	}

});