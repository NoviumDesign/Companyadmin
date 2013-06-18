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
	}

	function __destruct()
    {
    	if(!$this->error) {
    		// action
    		$action = $this->getRequest()->getActionName();

	    	// headers for file transfer
			header('Content-Disposition: inline; filename = ' . $action . '-' . trim($this->fileName) . '.pdf'); 
			header('Content-type: application/x-pdf'); 

			// create new pdf
			$this->pdf = new Emilk_Pdf();

			foreach ($this->document as $page) {
				$_page = $this->pdf->addPage();
				$_page->build($page);
				$_page->renderPage();
			}

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
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name as customer_name', 'customer_id', 'customer_adress', 'zip_code', 'city', 'country', 'box', 'reference', 'type'))
                     ->where('invoices.invoice_secret = "' . $this->secret . '" AND invoices.business = ' . $this->businessId);
        $result = $db->fetchAll($select);
        $invoice = $result[0];

        // items
        $select = $db->select()
                     ->from('items', 'quantity')
                     ->joinLeft('products','items.product = products.product_id', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit', 'vat'))
                     ->where('items.invoice = ' . $invoice['invoice_id'] . ' AND products.business = ' . $this->businessId)
                     ->order('product ASC');
        $items = $db->fetchAll($select);

        // business company
        $select = $db->select()
                     ->from('businesses', array('company_name', 'company_adress', 'company_zip_code', 'company_city', 'company_country', 'company_mail', 'company_phone', 'company_site', 'company_bank', 'company_orgnr', 'company_color', 'invoice_prefix', 'invoice_detail', 'company_reference', 'company_box'))
                     ->where('businesses.business_id = ' . $this->businessId);
        $result = $db->fetchAll($select);
        $company = $result[0];

        // theme color
        $themeColor = '#' . $company['company_color'];

        // file name
        $this->fileName = strip_tags(html_entity_decode($company['invoice_prefix'], ENT_QUOTES, 'UTF-8')) . $invoice['invoice_number'];


        if (count($items) > 10) {
	        require(APPLICATION_PATH . '/views/pdf/multiplePageInvoice.php');
        } else {
	        require(APPLICATION_PATH . '/views/pdf/onePageInvoice.php');
        }

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