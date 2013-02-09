<?php

class PdfController extends Zend_Controller_Action
{
    private $companySecret;
    private $businessSecret;
    private $secret;

    private $db;
    private $companyId;
    private $businessId;

	private $pdf;
	private $page;
	private $document;

    private $error = false;

    public function init()
    {
    	// disable layout and view
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);



        // parse parameters
        $parameters = new Emilk_Request_Parameters();
        $parameters = $parameters->get();

        // parameter check
        if(count($parameters) != 3) {
        	$this->error =  'Invalid url';
            exit();
        }

        // asign
        list($this->companySecret, $this->businessSecret, $this->secret) = $parameters;

        // connect to db
        $this->dbConnection();

		// create new pdf
		$this->pdf = new Emilk_Pdf();
		$this->page = $this->pdf->addPage();
	}

	function __destruct()
    {
    	if(!$this->error) {
    		// action
    		$action = $this->getRequest()->getActionName();


	    	// headers for file transfer
			header('Content-Disposition: inline; filename = ' . $action . '-' . $this->secret . '.pdf'); 
			header('Content-type: application/x-pdf'); 

			// render pdf
			$this->page->build($this->document);
			$this->page->renderPage();
			echo $this->pdf->render();
		} else {
			echo $this->error;
		}
    }

    public function invoiceAction()
    {
    	$db = $this->db;

    	// customer and invoice info
    	$select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'due', 'status', 'discount', 'notes'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name as customer_name', 'customer_id', 'customer_adress', 'zip_code', 'city', 'country'))
                     ->where('invoices.invoice_secret = "' . $this->secret . '" AND invoices.business = ' . $this->businessId);
        $result = $db->fetchAll($select);
        $invoice = $result[0];

        // items
        $select = $db->select()
                     ->from('items', 'quantity')
                     ->joinLeft('products','items.product = products.product_id', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit'))
                     ->where('items.invoice = ' . $invoice['invoice_id'] . ' AND products.business = ' . $this->businessId)
                     ->order('product ASC');
        $items = $db->fetchAll($select);

        // business company
        $select = $db->select()
                     ->from('businesses', array('company_name', 'company_adress', 'company_zip_code', 'company_city', 'company_country', 'company_mail', 'company_phone', 'company_site', 'company_bank', 'company_orgnr', 'company_color'))
                     ->where('businesses.business_id = ' . $this->businessId);
        $result = $db->fetchAll($select);
        $comapany = $result[0];

        // theme color
        $themeColor = '#' . $comapany['company_color'];


        // items
        $_items = '';
        $totalSum = 0;
        foreach($items as $item) {
        	$product = strip_tags(html_entity_decode($item['product'], ENT_QUOTES, 'UTF-8'));

        	$_items .= '
	        	<dimensions:525 18; padding: 3 10 3 10; font-size:10>
	        		<dimensions:250 12; font-size:10; color:#000000>' . 
	        			$product . '
	        		</>
	        		<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' . 
	        			$item['quantity'] . '
	        		</>
	        		<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' . 
	        			$item['price'] . ' :-
	        		</>
	        		<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' . 
	        			(float)$item['quantity']*(float)$item['price'] . ' :-
	        		</>
	        	</>';

        	$totalSum += (float)$item['quantity']*(float)$item['price'];
        }

        // total
        $sumUp = '';
        if($invoice['discount'] > 0) {
        	$totalSum += -$invoice['discount'];
        	$sumUp .= '
        		<dimensions:525 21; padding: 3 10 3 10; font-size:10>
					<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
						Rabatt
					</>
					<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' .
						$invoice['discount'] . ' :-
					</>
				</>';
        }
        $sumUp .= '
        	<dimensions:525 21; padding: 3 10 3 10; font-size:10>
				<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Delsumma
				</>
				<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' .
					$totalSum . ' :-
				</>
			</>
			<dimensions:525 21; padding: 3 10 3 10; font-size:10>
				<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Moms 25%
				</>
				<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' .
					$totalSum*0.25 . ' :-
				</>
			</>
			<dimensions:525 0.5; background-color:#646363></>
			<dimensions:525 21; margin-top:-16; padding: 3 10 3 10; font-size:10>
				<dimensions:420 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Att betala
				</>
				<dimensions:85 12; font-size:10; color:#000000; text-align:right; clear:none>' .
					$totalSum*1.25 . ' :-
				</>
			</>';





		// pdf document
		$this->document = '
<dimensions:595 842; padding:35>

	<dimensions:525 125>
		<dimensions:260 80; background-image:/companies/' . $this->companyId . '/logotypes/' . $this->businessId . '.jpg></>
		<dimensions:265 60; clear:none>
			<dimensions:265 30; padding-top:-5.5; clear:none; text-align:right; font-size:26; color: #646363>Faktura</>
			<dimensions:265 30; padding-top:-5.5; clear:none; text-align:right; font-size:26; color: #646363>Nr: ' . $invoice['invoice_number'] . '</>
		</>
		<dimensions:525 0.1; margin-top:44.9; background-color:#646363></>
	</>

	<dimensions:525 535>
		<dimensions:525 90; padding-left:10>
			<dimensions:170 50; margin-top:20; font-size:13; color:#646363>
				' . 
				strip_tags(html_entity_decode(ucfirst($comapany['company_name']), ENT_QUOTES, 'UTF-8')) . '<br>' .
				strip_tags(html_entity_decode(ucfirst($comapany['company_adress']), ENT_QUOTES, 'UTF-8')) . '<br>' .
				strip_tags(html_entity_decode($comapany['company_zip_code'], ENT_QUOTES, 'UTF-8')) . ' ' .
				strip_tags(html_entity_decode(ucfirst($comapany['company_city']), ENT_QUOTES, 'UTF-8')) . '<br>' .
				strip_tags(html_entity_decode(ucfirst($comapany['company_country']), ENT_QUOTES, 'UTF-8'))
      			. '
			</>
			<dimensions:105 55; margin-left:20; padding-top:4; color:' . $themeColor .' ; font-size:10; clear:none; text-align:center>
				FAKTURADATUM
				<dimensions:105 15; margin-top:14; color:#000000; font-size:10; text-align:center;>
					' . date('Y-m-d', $invoice['date']) /*ADD 1 HOUR*/ . '
				</>
			</>
			<dimensions:105 55; padding-top:4; color:#ffffff; font-size:10; clear:none; text-align:center; background-color:' . $themeColor .' >
				ATT BETALA
				<dimensions:105 15; margin-top:14; color:#ffffff; font-size:10; text-align:center;>
					' . $totalSum*1.25 . ' :-
				</>
			</>
			<dimensions:115 55; padding-top:4; color:' . $themeColor .' ; font-size:10; clear:none; text-align:center>
				FÖRFALLODATUM
				<dimensions:115 15; margin-top:14; color:#000000; font-size:10; text-align:center;>
					' . date('Y-m-d', $invoice['due']) . '
				</>
			</>
		</>

		<dimensions:525 425; margin-top:40>

			<dimensions:525 18; padding: 3 10 3 10; font-size:10>
				<dimensions:250 12; font-size:10; color:' . $themeColor .' >
					Beskriving
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Antal
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none; padding-right:-5>
					Á pris
				</>
				<dimensions:85 12; font-size:10; color:' . $themeColor .' ; text-align:right; clear:none>
					Belopp
				</>
			</>
			<dimensions:525 0.5; background-color:#646363></>
			<dimensions:525 240; margin-top:-13>
				' . $_items . '
			</>

			<dimensions:525 100>
				' . $sumUp . '
			</>
		</>
	</>

	<dimensions:525 112>
		<dimensions:525 0.1; margin-bottom:20; background-color:#646363></>
		
		<dimensions:525 43; padding: 3 10 3 10; font-size:10>
			<dimensions:170 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Adress
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode(ucfirst($comapany['company_adress']), ENT_QUOTES, 'UTF-8')) . '<br>' .
					strip_tags(html_entity_decode($comapany['company_zip_code'], ENT_QUOTES, 'UTF-8')) . ' ' .
					strip_tags(html_entity_decode(ucfirst($comapany['company_city']), ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:170 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Epost
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($comapany['company_mail'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Bankgiro
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($comapany['company_bank'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
		</>

		<dimensions:525 43; margin-top:6; padding: 3 10 3 10; font-size:10>
			<dimensions:170 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Webbsida
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($comapany['company_site'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:170 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Telefon
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($comapany['company_phone'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
			<dimensions:165 12; font-size:10; color:' . $themeColor .' ; clear:none>
				Organisationsnummer
				<dimensions:170 25; margin-top:3; font-size:10>' .
					strip_tags(html_entity_decode($comapany['company_orgnr'], ENT_QUOTES, 'UTF-8')) . '
				</>
			</>
		</>
	</>
	</>
		';

    }

    private function dbConnection()
    {
        // select company
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                     ->from('companies', 'company_id')
                     ->where('companies.company_secret = "' . $this->companySecret . '"');
        $result = $db->fetchAll($select);
        $companyId = $result[0]['company_id'];
        $this->companyId = $companyId;

        // create company connection
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/companies/' . $companyId . '/config.ini', APPLICATION_ENV);
        $this->db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => $config->db->host,
            'username' => $config->db->username,
            'password' => $config->db->password,
            'dbname'   => $config->db->dbname
        ));

        // select business
        $select = $this->db->select()
                     ->from('businesses', 'business_id')
                     ->where('businesses.business_secret = "' . $this->businessSecret . '"');
        $result = $this->db->fetchAll($select);
        $this->businessId = $result[0]['business_id'];
    }
}