<?php

class Form_AddCrForm extends Emilk_Form
{

	public function build()
	{
		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			 ->addChoises(array(
				'active',
				'completed'
			 ));

		$customerId = new Emilk_Form_Element_Hidden('customerId');

		$customer = new Emilk_Form_Element_Text('customer');
		$customer->setAttr('required', '');

		$date = new Emilk_Form_Element_Text('date');
		$date->setAttr('class', 'date')
			 ->setAttr('data-value', '+7');

		$task = new Emilk_Form_Element_Textarea('task');
		$task->setAttr('data-autogrow', 'true');

		$submit = new Emilk_Form_Element_Button('submit');
		$submit->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Add task');

		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/cr/add')
			 ->add(array(
			 	$status,
			 	$customerId,
			 	$customer,
			 	$date,
			 	$task,
			 	$submit
			 ));
	}
}