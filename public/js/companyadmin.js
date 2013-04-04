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

			if(!$that.is('.noColor')) {
				$that.parents('tr').removeClass(colors.join(' '))
				$that.parents('tr').addClass(color);
			}
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

$('.changeDeliveryStatus').live('click', function(event) {
	event.preventDefault();
	var status, statuses, index, id, colors;

	status = $(this).html();
	statuses = ['approved', 'completed'];
	colors = ['yellow', 'blue']
	id = $(this).data('id');

	index = (statuses.indexOf(status) + 1)%statuses.length

	$that = $(this);
	$.post(
    	'/ajax/deliverystatus',
		{
			'id': id,
			'status': statuses[index]
		},
		function(response){
			index = statuses.indexOf(response)%statuses.length
			color = colors[index]

			$that.html(response);

			if(!$that.is('.noColor')) {
				$that.parents('tr').removeClass(colors.join(' '))
				$that.parents('tr').addClass(color);
			}
    	}
    );
});


$('#changeDeliveryDate').live('change', function() {
	var action = 'view';
	if($(this).is('.mine')) {
		action = 'mine';
	}

	redirect('/deliveries/' + action + '/' + $(this).val(), '_self');
});

$('#widget_mails textarea').live('focus', function() {
	$(this)[0].select();

	$(this).live('mouseup', function() {
		$(this)[0].onmouseup = null;
        return false;
	})
});


//
//
// DELIVERIES
//
//
function checkDelivery() {
	var event = window.event;
	var checkbox = clickableThis.find('td:first input');

	if(event.shiftKey && checkDelivery.lastChecked) {
		var row = clickableThis.data('order-id');
		var deliveries = new Array();
		var rows = $('table#deliveries tbody tr');

		rows.map(function() {
			deliveries.push(parseInt($(this).data('order-id')));
		});

		if(-1 < deliveries.indexOf(checkDelivery.lastChecked) &&  -1 < deliveries.indexOf(row)) {
			var min = Math.min(deliveries.indexOf(checkDelivery.lastChecked), deliveries.indexOf(row));
			var max = Math.max(deliveries.indexOf(checkDelivery.lastChecked), deliveries.indexOf(row));

			rows.find('td:first input').attr('checked', false);
			rows.slice(min, max + 1).each(function() {
				$(this).find('td:first input').attr('checked', true);
			});
		}
	} else {
		checkbox.attr('checked', !checkbox.attr('checked'));
		if(checkbox.attr('checked')) {
			checkDelivery.lastChecked = checkbox.parents('tr').data('order-id');
		} else {
			checkDelivery.lastChecked = false;
		}
	}

	currentDeliverier();
}
$('#selectAll').live('click', function() {
	var status = $('table#deliveries tbody tr:first input').attr('checked');

	$('table#deliveries tbody tr input').attr('checked', !status);

	checkDelivery.lastChecked = false;
});



function currentDeliverier() {
	var rows, value, id, content, i;

	rows = $('table#deliveries tbody tr input:checked');

	if(rows.length == 0) {
		id = 0;
	} else {
		i = 0;
		rows.map(function() {

			if(i++ == 0) {
				id = value = parseInt($(this).val());
			} else {
				if(value != parseInt($(this).val())) {
					id = 0;
					return;
				}
			} 
		});
	}

	$('#carriers option').each(function() {
		if(id == parseInt($(this).val())) {
			content = $(this).attr('selected', 'selected').html();
			return;
		}
	});
	$('#carriers').prev('span').html(content);

	$('#numSelected').html(rows.length ? '(' + rows.length + ')' : '');
}

function updateCarrier(id) {
	var deliveries = new Array();
	var rows = $('table#deliveries tbody tr input:checked');

	if(!rows.length) {
		return;
	}

	if(typeof id != 'number') {
		id = parseInt($('#carriers').val());
	}

	if(!id) {
		return;
	} else if (id === -1) {
		id = 0;
	}

	rows.map(function() {
		deliveries.push(parseInt($(this).parents('tr').data('order-id')))
	});

	$.post(
    	'/ajax/carrier',
		{
			'carrier': id,
			'orders': deliveries
		},
		function(response){
			if(response.success) {
				$('table#deliveries tbody tr').each(function() {
					var i = jQuery.inArray($(this).data('order-id'), response.updated);
					if(-1 < i) {

						var name = response.carrier.name.charAt(0).toUpperCase() + response.carrier.name.slice(1)

						$(this).removeClass('red blue').addClass(response.carrier.id ? 'blue' : 'red');
						$(this).find('input').val(response.carrier.id);
						$(this).find('td.carrier').html(name);
					}
				});
			}
    	},
    	'json'
    );

}
$('#carriers').live('focus', function() {
	$('#carriers').bind('change', updateCarrier);
});
$('#carriers').live('blur', function() {
	$('#carriers').unbind('change', updateCarrier);
});
$('#removeCarrier').live('click', function() {
	updateCarrier(-1)
});