<?php

class Form_DeleteBusinessForm extends Emilk_Form
{
	public function build()
	{
		$password = new Emilk_Form_Element_Password('password');
		$password->setAttr('required', '');

		$delete = new Emilk_Form_Element_Button('delete');
		$delete->setAttr('class', 'submit red')
				->setValue('submit')
				->setText('Delete Business');

		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->add(array(
			 	$password,
			 	$delete
			 ));
	}
}