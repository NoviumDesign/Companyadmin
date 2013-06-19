<?php

class Form_EditInvoiceForm extends Emilk_Form
{	
	public $invoiceId = 0;

	function __construct($invoiceId) {
        parent::__construct();

        $this->invoiceId = $invoiceId;
    }

	public function build()
	{
		$db = Zend_Registry::get('db');
		$business = $_SESSION['business'];

		// order data
		$select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'customer', 'status', 'customer as customer_id', 'discount', 'due', 'date', 'notes'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', 'name as customer_name')
                     ->where('invoices.invoice_id = '. $this->invoiceId . ' AND invoices.business = ' . $business); 
        $result = $db->fetchAll($select);
        $invoice = $result[0];

        if(!$invoice) {
			header('Location: /invoices/view');
        }

		// products
        $select = $db->select()
                     ->from('products', array('product_id', 'product',
                        '(SELECT price FROM prices WHERE products.price = prices.price_id) as momentary_price',
                        '(SELECT unit FROM prices WHERE products.price = prices.price_id) as momentary_unit'))
                     ->joinLeft('items', 'items.product = products.product_id AND items.invoice = '. $this->invoiceId, 'quantity')
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit'))
                     ->where('products.business = ' . $business . ' AND (items.invoice = ' . $this->invoiceId. ' OR products.status <> "deleted")')
                     ->order('product ASC');
        $result = $db->fetchAll($select);
		$this->products = $result;


        $invoiceNumber = new Emilk_Form_Element_Text('invoiceNumber');
		$invoiceNumber->setAttr('class', 'autocomplete')
				      ->setAttr('required', '')
				      ->setAttr('data-errortext', 'You can\'t add a new invoice without a invoice number')
				      ->setValue($invoice['invoice_number']);


		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			 ->addChoises(array(
				'paid',
				'unpaid'
			 ))
		     ->setAttr('data-errortext', 'You must select something')
		     ->setValue($invoice['status']);


		$customerId = new Emilk_Form_Element_Hidden('customerId');
		$customerId->setValue($invoice['customer_id']);

		$customer = new Emilk_Form_Element_Text('customer');
		$customer->setAttr('class', 'autocomplete')
				 ->setAttr('required', '')
				 ->setAttr('data-errortext', 'You can\'t add a new invoice without a customer')
				 ->setValue($invoice['customer_name']);


    $invoiceDue = new Emilk_Form_Element_Text('invoiceDue');
    $invoiceDue->setAttr('class', 'date')
           ->setValue(date('Y-m-d', $invoice['due']));

    $invoiceDate = new Emilk_Form_Element_Text('invoiceDate');
    $invoiceDate->setAttr('class', 'date')
           ->setValue(date('Y-m-d', $invoice['date']));


		$products = array();
		foreach($this->products as $product) {

			$products[$product['product_id']] = new Emilk_Form_Element_Number('item[' . $product['product_id'] . ']');
			$products[$product['product_id']]->setAttr('class', 'decimal')
						 					 ->setAttr('data-min', '0')
					     					 ->setValue($product['quantity']);

		}


		$discount = new Emilk_Form_Element_Text('discount');
		$discount->setAttr('class', 'autocomplete')
				 ->setValue($invoice['discount']);


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true')
			  ->setValue($invoice['notes']);


		$addInvoice = new Emilk_Form_Element_Button('addInvoice');
		$addInvoice->setAttr('class', 'submit green')
				   ->setValue('submit')
				   ->setText('Edit Invoice');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/invoice/edit/' . $this->invoiceId)
			 ->add(array(
			 	$invoiceNumber,
			 	$customerId,
			 	$customer,
			 	$invoiceDue,
        $invoiceDate,
			 	$status,
			 	$discount,
			 	$notes,
			 	$addInvoice
			 ))
			 ->add($products);
	}
}