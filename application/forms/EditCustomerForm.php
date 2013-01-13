<?php

class Form_EditCustomerForm extends Emilk_Form
{	
	public $customerId;

	function __construct($customerId)
	{
        parent::__construct();
        
		$this->customerId = $customerId;
	}

	public function build()
	{
        $db = Zend_Registry::get('db');

        // form data
        $select = $db->select()
                     ->from('customers', array('registered', 'name', 'type', 'mail', 'phone', 'customer_adress', 'box', 'zip_code', 'city', 'country', 'notes'))
                     ->where('customers.customer_id = ' . $this->customerId);
        $result = $db->fetchAll($select);
        $customer = $result[0];

        if(!$customer) {
			header('Location: /customers/view');
        }


        $customer = $result[0];


        $registered = new Emilk_Form_Element_Radio('registered');
		$registered->setAttr('required', '')
				   ->addChoises(array(
				      'true',
				      'false'
				   ))
			       ->setAttr('data-errortext', 'You must select something')
			       ->setValue($customer['registered']);


		$type = new Emilk_Form_Element_Radio('type');
		$type->setAttr('required', '')
			 ->addChoises(array(
				'private',
				'company'
			 ))
		     ->setAttr('data-errortext', 'You must select something')
		     ->setValue($customer['type']);


		$customerName = new Emilk_Form_Element_Text('customerName');
		$customerName->setAttr('class', 'autocomplete')
				     ->setAttr('required', '')
				     ->setAttr('data-errortext', 'You can\'t add a new order without a customer name')
				     ->setValue($customer['name']);				     


		$phone = new Emilk_Form_Element_Text('phone');
		$phone->setAttr('class', 'autocomplete')
		      ->setValue($customer['phone']);


		$mail = new Emilk_Form_Element_Text('mail');
		$mail->setAttr('class', 'autocomplete')
		     ->setValue($customer['mail']);


		$adress = new Emilk_Form_Element_Text('adress');
		$adress->setAttr('class', 'autocomplete')
		       ->setValue($customer['customer_adress']);


		$box = new Emilk_Form_Element_Text('box');
		$box->setAttr('class', 'autocomplete')
		    ->setValue($customer['box']);


		$zipCode = new Emilk_Form_Element_Text('zipCode');
		$zipCode->setAttr('class', 'autocomplete')
		        ->setValue($customer['zip_code']);


		$city = new Emilk_Form_Element_Text('city');
		$city->setAttr('class', 'autocomplete')
		     ->setValue($customer['city']);


		$country = new Emilk_Form_Element_Text('country');
		$country->setAttr('class', 'autocomplete')
		        ->setValue($customer['country']);


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true')
			  ->setValue($customer['notes']);


		$editCustomer = new Emilk_Form_Element_Button('editCustomer');
		$editCustomer->setAttr('class', 'submit blue')
				    ->setValue('submit')
				    ->setText('Edit Customer');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/customer/view/' . $this->customerId)
			 ->add(array(
			 	$registered,
			 	$type,
			 	$customerName,
			 	$phone,
			 	$mail,
			 	$adress,
			 	$box,
			 	$zipCode,
			 	$city,
			 	$country,
			 	$notes,
			 	$editCustomer
			 ));
	}
}