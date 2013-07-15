$('#product-list li a').click(function (event) {
	$('#product-basket tr.id-' + $(this).data('secret')).removeClass('hidden');

	$(this).parent('li').addClass('hidden')
});

$('#product-basket tr .remove').click(function (event) {
	$(this).parents('tr').addClass('hidden');
	$(this).parents('tr').find('input').val('');

	var secret = $(this).parents('tr').data('secret');
	$('#product-list li').find("[data-secret='" + secret + "']").parent('li').removeClass('hidden');
});


$('#submit').click(function (event) {

	// box ord adress
	if (!$('#adress').val() && !$('#box').val()) {
		alert('Du måste fylla i antingen postadress eller box!');
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
		alert('Din order innehåller inga produkter!');
		event.preventDefault();
		return false;
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