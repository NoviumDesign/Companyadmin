<?php

class Form_AddCustomerForm extends Emilk_Form
{
	public function build()
	{
		$type = new Emilk_Form_Element_Radio('type');
		$type->setAttr('required', '')
			 ->addChoises(array(
				'private',
				'company'
			 ))
		     ->setAttr('data-errortext', 'You must select something');


		$customerName = new Emilk_Form_Element_Text('customerName');
		$customerName->setAttr('class', 'autocomplete')
				     ->setAttr('required', '')
				     ->setAttr('data-errortext', 'You can\'t add a new order without a customer name');


		$phone = new Emilk_Form_Element_Text('phone');
		$phone->setAttr('class', 'autocomplete');


		$mail = new Emilk_Form_Element_Text('mail');
		$mail->setAttr('class', 'autocomplete');


		$adress = new Emilk_Form_Element_Text('adress');
		$adress->setAttr('class', 'autocomplete');


		$box = new Emilk_Form_Element_Text('box');
		$box->setAttr('class', 'autocomplete');


		$zipCode = new Emilk_Form_Element_Text('zipCode');
		$zipCode->setAttr('class', 'autocomplete');


		$city = new Emilk_Form_Element_Text('city');
		$city->setAttr('class', 'autocomplete');


		$country = new Emilk_Form_Element_Text('country');
		$country->setAttr('class', 'autocomplete');


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setAttr('data-autogrow', 'true');


		$addCustomer = new Emilk_Form_Element_Button('addCustomer');
		$addCustomer->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Add Customer');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/customer/add')
			 ->add(array(
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
			 	$addCustomer
			 ));
	}
}