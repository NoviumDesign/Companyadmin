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
var clickableThis = '';
$('.clickable').live('mouseup', function(event) {

	if($(event.srcElement).parents('.noClick').length) {
		return;
	}

	var target = '_self'

	if(event.which == 2 || event.which == 3 || event.ctrlKey || event.shiftKey) {
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
	// event.preventDefault();

	// if target contain link
	if($targetTd.data('link')) {
		// link via td
		clickableThis = $targetTd;
		redirect($targetTd.data('link'), target)
		return;
	}

	// if parent td contain link
	if($(this).data('link')) {
		// link via td
		clickableThis = $(this);
		redirect($(this).data('link'), target)
		return;
	}

});
var redirect = function(url, target) {
	if(url.indexOf('function(') != 0) {
		window.open(url, target)
	} else {
		func = url.substring('function('.length, url.length - 1)

		if(func) {
			//Create the function
			var fn = window[func];
			 
			//Call the function
			fn();
		}
	}
}


$('.changeOrderStatus').live('click', function(event) {
	event.preventDefault();
	var status, statuses, index, id, colors;

	status = $(this).html();
	statuses = ['new', 'active', 'completed', 'invoice'];
	colors = ['blue', 'yellow', 'green', 'orange']
	id = $(this).data('id');

	index = (statuses.indexOf(status) + 1)%statuses.length

	$that = $(this);
	$.post(
    	'/ajax/orderstatus',
		{
			'id': id,
			'status': statuses[index]
		},
		function(response){
			index = statuses.indexOf(response)%statuses.length
			color = colors[index]

			$that.html(response);

			$that.parents('tr').removeClass(colors.join(' '))
			$that.parents('tr').addClass(color)
    	}
    );
});

$('.changeInvoiceStatus').live('click', function(event) {
	event.preventDefault();
	var status, statuses, index, id, colors;

	status = $(this).html();
	statuses = ['unpaid', 'paid'];
	colors = ['yellow', 'green']
	id = $(this).data('id');

	index = (statuses.indexOf(status) + 1)%statuses.length

	$that = $(this);
	$.post(
    	'/ajax/invoicestatus',
		{
			'id': id,
			'status': statuses[index]
		},
		function(response){
			index = statuses.indexOf(response)%statuses.length
			color = colors[index]

			$that.html(response);

			$that.parents('tr').removeClass(colors.join(' '))
			$that.parents('tr').addClass(color)
    	}
    );
});

$('.changeCrStatus').live('click', function(event) {
	event.preventDefault();
	var status, statuses, index, id, colors;

	status = $(this).html();
	statuses = ['active', 'completed'];
	colors = ['yellow', 'green']
	id = $(this).data('id');

	index = (statuses.indexOf(status) + 1)%statuses.length

	$that = $(this);
	$.post(
    	'/ajax/crstatus',
		{
			'id': id,
			'status': statuses[index]
		},
		function(response){
			index = statuses.indexOf(response)%statuses.length
			color = colors[index]

			$that.html(response);

			$that.parents('tr').removeClass(colors.join(' '))
			$that.parents('tr').addClass(color)
    	}
    );
});


$('#changeDeliveryDate').live('change', function() {
	redirect('/deliveries/view/' + $(this).val(), '_self');
});

$('#widget_mails textarea').live('focus', function() {
	$(this)[0].select();

	$(this).live('mouseup', function() {
		$(this)[0].onmouseup = null;
        return false;
	})
});

function checkDelivery() {
	var checkbox = clickableThis.find('td:first input');
	checkbox.attr("checked", !checkbox.attr("checked"));
}