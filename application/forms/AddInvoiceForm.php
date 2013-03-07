<?php

class Form_AddInvoiceForm extends Emilk_Form
{
		public $orderId = null;
		public $products = null;

	function __construct($orderId) {
        parent::__construct();

        $this->orderId = $orderId;
    }

	public function build()
	{
		$db = Zend_Registry::get('db');
		$business = $_SESSION['business'];


		if($this->orderId) {

			$select = $db->select()
	                     ->from('orders', array('order_number', 'customer as customer_id', 'notes'))
	                     ->joinLeft('customers', 'orders.customer = customers.customer_id', 'name as customer_name')
	                     ->where('orders.order_id = ' . $this->orderId . ' AND orders.business = ' . $_SESSION['business']);
	        $result = $db->fetchAll($select);
	        $order = $result[0];

	        if($order) {
		        $select = $db->select()
		                     ->from('products', array('product_id', 'product'))
		                     ->joinLeft('items', 'items.product = products.product_id AND items.order = '. $this->orderId, 'quantity')
		                     ->joinLeft('prices', 'prices.price_id = items.price', array(
		                     	'COALESCE(prices.price, (SELECT price FROM prices WHERE products.price = prices.price_id)) AS price',
		                     	'COALESCE(prices.unit, (SELECT unit FROM prices WHERE products.price = prices.price_id)) AS unit'))
		                     ->where('products.business = ' . $_SESSION['business'] . ' AND products.status <> "deleted"')
		                     ->order('product ASC');
		        $this->products = $db->fetchAll($select);

		        // check if invoice_number as order_number is free to use
		        $select = $db->select()
		                     ->from('invoices', 'invoice_id')
		                     ->where('invoices.invoice_number = ' . $order['order_number'] . ' AND invoices.business = ' . $_SESSION['business']);
		        $result = $db->fetchAll($select);


	        } else {
				header('Location: /invoice/add');
	   		}


		} else {
			// products
	        $select = $db->select()
	                     ->from('products', array('product_id', 'product'))
	                     ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
	                     ->where('products.business = ' . $business . ' AND products.status <> "deleted"')
	                     ->order('product ASC');
	        $result = $db->fetchAll($select);
	        $this->products = $result;
		}


		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			 ->addChoises(array(
				'paid',
				'unpaid'
			 ))
		     ->setAttr('data-errortext', 'You must select something');



        $customerId = new Emilk_Form_Element_Hidden('customerId');

		$customer = new Emilk_Form_Element_Text('customer');
		$customer->setAttr('class', 'autocomplete')
				 ->setAttr('required', '')
				 ->setAttr('data-errortext', 'You can\'t add a new invoice without a customer');



		$invoiceDue = new Emilk_Form_Element_Text('invoiceDue');
		$invoiceDue->setAttr('class', 'date')
				   ->setAttr('data-value', '+10');


		$products = array();
		foreach($this->products as $product) {

			$products[$product['product_id']] = new Emilk_Form_Element_Number('item[' . $product['product_id'] . ']');
			$products[$product['product_id']]->setAttr('class', 'decimal')
						 					 ->setAttr('data-min', '0');

			if(isset($product['quantity'])) {
				$products[$product['product_id']]->setValue($product['quantity']);
			}

		}


		$discount = new Emilk_Form_Element_Text('discount');
		$discount->setAttr('class', 'autocomplete');


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true');


		$addInvoice = new Emilk_Form_Element_Button('addInvoice');
		$addInvoice->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Add Invoice');

		$orderId = new Emilk_Form_Element_Hidden('orderId');

		if($this->orderId) {
			$customerId->setValue($order['customer_id']);
		    $customer->setValue($order['customer_name']);
			$notes->setValue($order['notes']);
			$status->setValue('unpaid');
			$orderId->setValue($this->orderId);
		}


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/invoice/add')
			 ->add(array(
			 	$customerId,
			 	$customer,
			 	$invoiceDue,
			 	$status,
			 	$discount,
			 	$notes,
			 	$addInvoice,
			 	$orderId
			 ))
			 ->add($products);
	}
}