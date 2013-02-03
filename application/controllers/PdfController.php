<?php

class PdfController extends Zend_Controller_Action
{
	private $pdf;
	private $page;

    public function init()
    {
    	// diable layout and view
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		// create new pdf
		$this->pdf = new Emilk_Pdf();
	}

    public function invoiceAction()
    {
    	// pointers
		$pdf = &$this->pdf;
		$page = &$this->page;

		// add new page to the document 
		$page = $pdf->addPage();

		$html = '
<dimensions:595 842; padding:35>

	<dimensions:525 125>
		<dimensions:260 80; background-color:#34388a; background-image:/companies/1/logotypes/test.png></>
		<dimensions:265 60; clear:none>
			<dimensions:265 30; padding-top:-5.5; clear:none; text-align:right; font-size:26; color: #646363>Faktura</>
			<dimensions:265 30; padding-top:-5.5; clear:none; text-align:right; font-size:26; color: #646363>Nr: 1</>
		</>
		<dimensions:525 0.1; margin-top:44.9; background-color:#646363></>
	</>

	<dimensions:525 555>
		<dimensions:525 90; padding-left:10>
			<dimensions:170 50; margin-top:20; font-size:13; color:#646363>
				Novium Designbyrå<br>Aftongatan 49<br>582 49 Linköping
			</>
			<dimensions:105 55; margin-left:20; padding-top:4; color:#303688; font-size:10; clear:none; text-align:center>
				FAKTURADATUM
				<dimensions:105 15; margin-top:14; color:#000000; font-size:10; text-align:center;>
					25/4-2012
				</>
			</>
			<dimensions:105 55; padding-top:4; color:#ffffff; font-size:10; clear:none; text-align:center; background-color:#303688>
				ATT BETALA
				<dimensions:105 15; margin-top:14; color:#000000; font-size:10; text-align:center;>
					2 500 :-
				</>
			</>
			<dimensions:115 55; padding-top:4; color:#303688; font-size:10; clear:none; text-align:center>
				FÖRFALLODATUM
				<dimensions:115 15; margin-top:14; color:#000000; font-size:10; text-align:center;>
					25/5-2012
				</>
			</>
		</>

		<dimensions:525 425; margin-top:40>

			<dimensions:525 18; padding: 3 10 3 10; font-size:10>
				<dimensions:250 12; font-size:10; color:#303688>
					Beskriving
				</>
				<dimensions:85 12; font-size:10; color:#303688; text-align:right; clear:none>
					Antal
				</>
				<dimensions:85 12; font-size:10; color:#303688; text-align:right; clear:none; padding-right:-5>
					Á pris
				</>
				<dimensions:85 12; font-size:10; color:#303688; text-align:right; clear:none>
					Belopp
				</>
			</>

			<dimensions:525 0.5; background-color:#646363></>

			<dimensions:525 240; margin-top:-13>

				<dimensions:525 18; padding: 3 10 3 10; font-size:10>
					<dimensions:250 12; font-size:10; color:#000000>
						Produkt1
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						1
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						200:-
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						200:-
					</>
				</>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10>
					<dimensions:250 12; font-size:10; color:#000000>
						Produkt2
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						5
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						100:-
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						500:-
					</>
				</>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
				<dimensions:525 18; padding: 3 10 3 10; font-size:10><dimensions:250 12; font-size:10; color:#000000>Produkt2</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>5</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>100:-</><dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>500:-</></>
			</>

			<dimensions:525 100>
				<dimensions:525 21; padding: 3 10 3 10; font-size:10>
					<dimensions:420 12; font-size:10; color:#303688; text-align:right; clear:none>
						Delsumma
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						700:-
					</>
				</>
				<dimensions:525 21; padding: 3 10 3 10; font-size:10>
					<dimensions:420 12; font-size:10; color:#303688; text-align:right; clear:none>
						Moms 25%
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						875:-
					</>
				</>
				<dimensions:525 0.5; background-color:#646363></>
				<dimensions:525 21; margin-top:-16; padding: 3 10 3 10; font-size:10>
					<dimensions:420 12; font-size:10; color:#303688; text-align:right; clear:none>
						Att betala
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>
						875:-
					</>
				</>
			</>
		</>
	</>

	<dimensions:525 92>
		<dimensions:525 0.5; background-color:#646363></>
		
		<dimensions:525 43; padding: 3 10 3 10; font-size:10>
			<dimensions:170 12; font-size:10; color:#303688; clear:none>
				Adress
				<dimensions:170 25; margin-top:3; font-size:10>
					Aftongatan 49<br>589 53 Linköping
				</>
			</>
			<dimensions:170 12; font-size:10; color:#303688; clear:none>
				Epost
				<dimensions:170 25; margin-top:3; font-size:10>
					info@noviumdesign.se
				</>
			</>
			<dimensions:165 12; font-size:10; color:#303688; clear:none>
				Bankgiro
				<dimensions:170 25; margin-top:3; font-size:10>
					775-8402
				</>
			</>
		</>

		<dimensions:525 43; margin-top:6; padding: 3 10 3 10; font-size:10>
			<dimensions:170 12; font-size:10; color:#303688; clear:none>
				Webbsida
				<dimensions:170 25; margin-top:3; font-size:10>
					Aftongatan 49<br>589 53 Linköping
				</>
			</>
			<dimensions:170 12; font-size:10; color:#303688; clear:none>
				Telefon
				<dimensions:170 25; margin-top:3; font-size:10>
					info@noviumdesign.se
				</>
			</>
			<dimensions:165 12; font-size:10; color:#303688; clear:none>
				Innehar F-skattesedel
			</>
		</>
	</>

</>
		';



		



		$page->build($html);

		// print_r($page->elements);


		$page->renderPage();




		// headers for file transfer
		header('Content-Disposition: inline; filename = ' . 'result' . '.pdf'); 
		header('Content-type: application/x-pdf'); 

		// render pdf
		echo $pdf->render();
    }
}