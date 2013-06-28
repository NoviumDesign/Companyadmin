$('#product-list option').click(function (event) {
	$('#product-basket tr.id-' + $(this).val()).removeClass('hidden');

	$("#product-list option:selected").removeAttr("selected");
});

$('#product-basket tr .remove').click(function (event) {
	$(this).parents('tr').addClass('hidden');
	$(this).parents('tr').find('input').val('');
});


$('#submit').click(function (event) {

	// box ord adress
	if (!$('#adress').val() && !$('#box').val()) {
		alert('Du måste fylla i antingen postadress eller box!')
		event.preventDefault();
		return false;
	}

	// products
	var products = false;
	$('#product-basket input.products').each(function () {
		if ($(this).val() > 0) {
			products = true;
			return;
		}
	});
	
	if (!products) {
		alert('Din order innehåller inga produkter!')
	}
});

$('.type').click(function () {
	if($(this).val() == 'company') {
		$('.company').removeClass('hidden');
		$('.private').addClass('hidden');
	} else {
		$('.private').removeClass('hidden');
		$('.company').addClass('hidden');
		$('#reference').val('');
	}
});

// jQuery datepicker opt-in.
$(function() {
	$( "#datepicker" ).datepicker();
});

// jQuery timepicker opt-in.
$('#timepicker').timepicker();