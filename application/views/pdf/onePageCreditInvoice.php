<?php

// items
$_items = '';
$totalSum = 0;
foreach($items as $item) {
	$product = strip_tags(html_entity_decode($item['product'], ENT_QUOTES, 'UTF-8'));

	$_items .= '
    	<dimensions:525 18; padding: 3 10 3 10; font-size:10>
    		<dimensions:250 12; font-size:10>' . 
    			$product . '
    		</>
    		<dimensions:85 12; font-size:10; text-align:right; clear:none>' . 
    			$item['quantity'] . '
    		</>
    		<dimensions:85 12; font-size:10; text-align:right; clear:none>' . 
    			round($item['price'], 2) . ':- 
    		</>
    		<dimensions:85 12; font-size:10; text-align:right; clear:none>' . 
    			round((float)$item['quantity']*(float)$item['price'], 2) . ':-
    		</>
    	</>';

	$totalSum += (float)$item['quantity']*(float)$item['price'];
}

$discount = (float)$invoice['discount'];
$totalVat = 0;
foreach($items as $item) {
    $price = (float)$item['price'];
    $quantity = (float)$item['quantity'];
    $vat = (0.01*(float)$item['vat']);

	$totalVat += $quantity*$price*(1 - $discount/$totalSum)*$vat;
}

// total
$sumUp = '';
$sumUp .= '
	<dimensions:525 21; padding: 3 10 3 10; font-size:10>
		<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
			Delsumma
		</>
		<dimensions:85 12; font-size:10; text-align:right; clear:none>' .
			round($totalSum, 2) . ':-
		</>
	</>';
if($invoice['discount'] > 0) {
	$sumUp .= '
		<dimensions:525 21; padding: 3 10 3 10; font-size:10>
			<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
				Rabatt
			</>
			<dimensions:85 12; font-size:10; text-align:right; clear:none>' .
				round($invoice['discount'], 2) . ':-
			</>
		</>';
}
$sumUp .='
	<dimensions:525 21; padding: 3 10 3 10; font-size:10>
		<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
			Moms
		</>
		<dimensions:85 12; font-size:10; text-align:right; clear:none>' .
			round($totalVat, 2) . ':-
		</>
	</>
	<dimensions:525 21; padding: 3 10 3 10; font-size:10>
		<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none; padding-left:5>
			Öresavrundning
		</>
		<dimensions:85 12; font-size:10; text-align:right; clear:none>' .
			round(round($totalSum - $discount + $totalVat) - ($totalSum - $discount + $totalVat), 2) . ':-
		</>
	</>
	<dimensions:525 0.5; background-color:#646363></>
	<dimensions:525 21; margin-top:-16; padding: 3 10 3 10; font-size:10>
		<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
			Att Erhålla
		</>
		<dimensions:85 12; font-size:10; text-align:right; clear:none>' .
			round($totalSum - $discount + $totalVat) . ':-
		</>
	</>';

/// pdf document 
$this->document[0] = '
<dimensions:595 842; padding:35>

	<dimensions:525 60>
		<dimensions:220 60; background-image:/companies/' . $this->companyId . '/logotypes/' . $this->businessId . '.jpeg></>
		<dimensions:305 60; clear:none; text-align:right; font-size:24>
			Kreditfaktura
		</>
	</>

	<dimensions:525 60; margin-top:25;>
		<dimensions:315 60; font-size:13>' . 
			strip_tags(html_entity_decode(ucfirst($company['company_name']), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode(ucfirst(($company['company_adress']? $company['company_adress']: $company['company_box'])), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode($company['company_zip_code'], ENT_QUOTES, 'UTF-8')) . ' ' .
			strip_tags(html_entity_decode(ucfirst($company['company_city']), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode(ucfirst($company['company_country']), ENT_QUOTES, 'UTF-8')). '
		</>
		<dimensions:200 60; font-size:13; clear:none>' . 
			strip_tags(html_entity_decode(ucfirst($invoice['customer_name']), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode(ucfirst(($invoice['customer_adress']? $invoice['customer_adress']: $invoice['box'])), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode($invoice['zip_code'], ENT_QUOTES, 'UTF-8')) . ' ' .
			strip_tags(html_entity_decode(ucfirst($invoice['city']), ENT_QUOTES, 'UTF-8')) . '<br>' .
			strip_tags(html_entity_decode(ucfirst($invoice['country']), ENT_QUOTES, 'UTF-8')). '
		</>
	</>

	<dimensions:525 507; margin-top:25>
		<dimensions:525 70; padding-left:10>
			<dimensions:525 0.1; margin:0 0 10 -10; background-color:#646363></>

			<dimensions:68 30; color:' . $themeColor .' ; font-size:10; clear:none>
				Faktura.nr
				<dimensions:68 15; margin-top:3; font-size:10;>
					' . strip_tags(html_entity_decode($company['invoice_prefix'], ENT_QUOTES, 'UTF-8')) . $invoice['invoice_number'] . '
				</>
			</>

			<dimensions:105 30; color:' . $themeColor .' ; font-size:10; clear:none>
				Er referens
				<dimensions:95 15; margin-top:3; font-size:10;>
					' . ($invoice['type'] == 'company'? html_entity_decode(ucfirst($invoice['reference']), ENT_QUOTES, 'UTF-8'): html_entity_decode(ucfirst($invoice['customer_name']), ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:105 30;color:' . $themeColor .' ; font-size:10; clear:none>
				Vår referens
				<dimensions:95 15; margin-top:3; font-size:10;>
					' . strip_tags(html_entity_decode(ucfirst($company['company_reference']), ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:80 30; color:' . $themeColor .' ; font-size:10; clear:none>
				Fakturadatum
				<dimensions:80 15; margin-top:3; font-size:10;>
					' . date('Y-m-d', $invoice['date']) . '
				</>
			</>

		</>

		<dimensions:525 451>

			<dimensions:525 18; padding: 3 10 3 10; font-size:10>
				<dimensions:250 12; font-size:10; color:' . $themeColor .' >
					Beskriving
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Antal
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none; padding-left:5>
					Á pris
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Belopp
				</>
			</>
			<dimensions:525 0.5; background-color:#646363></>
			<dimensions:525 190; margin-top:-13>
				' . $_items . '
			</>

			<dimensions:525 105>
				' . $sumUp . '
			</>
			<dimensions:525 106; margin-top:-72; padding:0 10 0 10>
				<dimensions: 505 ' . ($invoice['discount'] > 0? 56: 56+15) . '; margin-top:' . ($invoice['discount'] > 0? 15: 0) . '; font-size:10>' .
					strip_tags(html_entity_decode(ucfirst($invoice['notes']), ENT_QUOTES, 'UTF-8')) . '
				</>

				<dimensions: 505 25; margin-top:10; font-size:10>' .
					strip_tags(html_entity_decode(ucfirst($company['invoice_detail']), ENT_QUOTES, 'UTF-8')) . '
				</>


			</>
		</>
	</>

	<dimensions:525 90>
		<dimensions:525 0.1; margin-bottom:10; background-color:#646363></>
		
		<dimensions:525 43; padding: 3 10 3 10; font-size:10>
			<dimensions:175 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Adress
				<dimensions:175 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode(ucfirst($company['company_adress']), ENT_QUOTES, 'UTF-8')) . '<br>' .
					strip_tags(html_entity_decode($company['company_zip_code'], ENT_QUOTES, 'UTF-8')) . ' ' .
					strip_tags(html_entity_decode(ucfirst($company['company_city']), ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Telefon
				<dimensions:165 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($company['company_phone'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Epost
				<dimensions:165 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($company['company_mail'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
		</>

		<dimensions:525 31; margin-top:6; padding: 3 10 3 10; font-size:10>
			<dimensions:175 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Webbsida
				<dimensions:175 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($company['company_site'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Bankgiro
				<dimensions:165 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($company['company_bank'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Organisationsnummer
				<dimensions:165 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($company['company_orgnr'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
		</>
	</>
</>
	';