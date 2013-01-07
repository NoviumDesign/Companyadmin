<?php

class Form_AddOrderForm extends Emilk_Form
{
	public function build()
	{

		$customerId = new Emilk_Form_Element_Text('customerId');
		$customerId->setAttr('class', 'autocomplete')
				   // ->setAttr('data-source', '[abc,def,ghi,jkl,mno,pqr,stu,vwx,yz]')
				   ->setAttr('required', '')
				   ->setAttr('data-errortext', 'You can\'t add a new order without a customer');


		$orderContent = new Emilk_Form_Element_Number('orderContent');
		$orderContent->setAttr('class', 'decimal')
					 ->setAttr('data-min', '0');


		$delivery = new Emilk_Form_Element_Radio('delivery');
		$delivery->setAttr('required', '')
				 ->addChoises(array(
					'approved',
					'requested',
					'none'
				 ));


		$deliveryDate = new Emilk_Form_Element_Text('deliveryDate');
		$deliveryDate->setAttr('class', 'date')
					 ->setAttr('data-value', '+7');


		$deliveryTime = new Emilk_Form_Element_Text('deliveryTime');
		$deliveryTime->setAttr('class', 'time')
					 ->setAttr('data-value', 'now');


		$deliveryAdress = new Emilk_Form_Element_Text('deliveryAdress');


		$orderNotes = new Emilk_Form_Element_Textarea('orderNotes');
		$orderNotes->setAttr('data-autogrow', 'true');


		$deliveryStatus = new Emilk_Form_Element_Radio('deliveryStatus');
		$deliveryStatus->setAttr('required', '')
					   ->addChoises(array(
					      'active',
					      'completed'
					   ));


		$addOrder = new Emilk_Form_Element_Button('addOrder');
		$addOrder->setAttr('class', 'submit')
				 ->setValue('submit')
				 ->setText('Add order');


		$custom1 = new Emilk_Form_Element_Text('custom1');
		$custom2 = new Emilk_Form_Element_Text('custom2');
		$custom3 = new Emilk_Form_Element_Text('custom3');




		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/order/add')
			 ->add(array(
			 	$customerId,
			 	$orderContent,
			 	$delivery,
			 	$deliveryDate,
			 	$deliveryTime,
			 	$deliveryAdress,
			 	$orderNotes,
			 	$deliveryStatus,
			 	$addOrder,
			 	$custom1,
			 	$custom2,
			 	$custom3,
			 ));

	}
}