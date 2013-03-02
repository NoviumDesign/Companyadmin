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
$('.clickable').live('mouseup', function(event) {
	var target = '_self'

	if(event.which == 2 || event.which == 3 || event.ctrlKey) {
		target = '_blank'
	}

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
		// link via td
		redirect($targetTd.data('link'), target)
		return;
	}

	// if parent td contain link
	if($(this).data('link')) {
		// link via td
		redirect($(this).data('link'), target)
		return;
	}

});
var redirect = function(url, target) {
	window.open(url, target)
}

$('.changeStatus').live('click', function(event) {
	event.preventDefault();
	var status, statuses, index, id;

	status = $(this).html();
	statuses = ['new', 'active', 'completed'];
	id = $(this).data('id');

	index = (statuses.indexOf(status) + 1)%statuses.length

	$that = $(this);
	$.post(
    	'/ajax/status',
		{
			'id': id,
			'status': statuses[index]
		},
		function(response){

			$that.html(response);

    	}
    );

});

