<?php

class Form_AddInvoiceForm extends Emilk_Form
{
	public function build()
	{
		$db = Zend_Registry::get('db');
		$business = $_SESSION['business'];

		// products
        $select = $db->select()
                     ->from('products', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
                     ->where('products.business = ' . $business . ' AND products.status <> "deleted"')
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->products = $result;

        // invoice number
        $select = $db->select()
                     ->from('invoices', '(COALESCE(MAX(invoice_number), 0) + 1) as invoiceNumber')
                     ->where('invoices.business =' . $_SESSION['business']);
        $result= $db->fetchAll($select);
        $_invoiceNumber = $result[0]['invoiceNumber'];


        $invoiceNumber = new Emilk_Form_Element_Text('invoiceNumber');
		$invoiceNumber->setAttr('class', 'autocomplete')
				   ->setAttr('required', '')
				   ->setAttr('data-errortext', 'You can\'t add a new invoice without a invoice number')
				   ->setValue($_invoiceNumber);


		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			 ->addChoises(array(
				'paid',
				'unpaid'
			 ))
		     ->setAttr('data-errortext', 'You must select something');


		$customer = new Emilk_Form_Element_Text('customer');
		$customer->setAttr('class', 'autocomplete')
				 ->setAttr('required', '')
				 ->setAttr('data-errortext', 'You can\'t add a new invoice without a customer');


		$invoiceDue = new Emilk_Form_Element_Text('invoiceDue');
		$invoiceDue->setAttr('class', 'date')
				   ->setAttr('data-value', '+30');


		$products = array();
		foreach($this->products as $product) {

			$products[$product['product_id']] = new Emilk_Form_Element_Number('item[' . $product['product_id'] . ']');
			$products[$product['product_id']]->setAttr('class', 'decimal')
						 					 ->setAttr('data-min', '0');

		}


		$discount = new Emilk_Form_Element_Text('discount');
		$discount->setAttr('class', 'autocomplete');


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true');


		$addInvoice = new Emilk_Form_Element_Button('addInvoice');
		$addInvoice->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Add Invoice');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/invoice/add')
			 ->add(array(
			 	$invoiceNumber,
			 	$customer,
			 	$invoiceDue,
			 	$status,
			 	$discount,
			 	$notes,
			 	$addInvoice
			 ))
			 ->add($products);
	}
}