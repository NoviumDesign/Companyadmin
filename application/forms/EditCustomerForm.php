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
                     ->from('customers', array('registered', 'name', 'type', 'mail', 'phone', 'customer_adress', 'box', 'zip_code', 'city', 'country', 'notes', 'reference'))
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
			       ->setValue($customer['registered']);


		$type = new Emilk_Form_Element_Radio('type');
		$type->setAttr('required', '')
			 ->addChoises(array(
				'private',
				'company'
			 ))
		     ->setValue($customer['type']);


		$customerName = new Emilk_Form_Element_Text('customerName');
		$customerName->setAttr('required', '')
				     ->setValue($customer['name']);


		$reference = new Emilk_Form_Element_Text('reference');
		$reference->setValue($customer['reference']);


		$phone = new Emilk_Form_Element_Text('phone');
		$phone->setValue($customer['phone']);

		$mail = new Emilk_Form_Element_Email('mail');
		$mail->setValue($customer['mail']);


		$adress = new Emilk_Form_Element_Text('adress');
		$adress->setValue($customer['customer_adress']);

		$box = new Emilk_Form_Element_Text('box');
		$box->setValue($customer['box']);

		$zipCode = new Emilk_Form_Element_Text('zipCode');
		$zipCode->setValue($customer['zip_code']);

		$city = new Emilk_Form_Element_Text('city');
		$city->setValue($customer['city']);

		$country = new Emilk_Form_Element_Text('country');
		$country->setValue($customer['country']);


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true')
			  ->setValue($customer['notes']);


		$editCustomer = new Emilk_Form_Element_Button('editCustomer');
		$editCustomer->setAttr('class', 'submit green')
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
			 	$editCustomer,
			 	$reference
			 ));
	}
}