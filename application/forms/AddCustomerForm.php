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
			 ));

		$customerName = new Emilk_Form_Element_Text('customerName');
		$customerName->setAttr('required', '');

		$reference = new Emilk_Form_Element_Text('reference');

		$phone = new Emilk_Form_Element_Text('phone');
		$mail = new Emilk_Form_Element_Email('mail');


		$adress = new Emilk_Form_Element_Text('adress');
		$box = new Emilk_Form_Element_Text('box');
		$zipCode = new Emilk_Form_Element_Text('zipCode');
		$city = new Emilk_Form_Element_Text('city');
		$country = new Emilk_Form_Element_Text('country');


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
			 	$addCustomer,
			 	$reference
			 ));
	}
}