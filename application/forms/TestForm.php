<?php

class Form_TestForm extends Emilk_Form
{
	public function build()
	{

		$textInput = new Emilk_Form_ELement_Text('name');
		$textInput->setValidation('mail', 'detta är ingen amil');

		$this->add(array($textInput))
			 ->setAttr('method', 'post');

	}
}