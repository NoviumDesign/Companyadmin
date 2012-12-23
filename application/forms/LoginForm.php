<?php

class Form_LoginForm extends Zend_Form
{
	public function __construct($option = null) {
		parent::__construct($option);

		$mail = new Zend_Form_Element_Text('mail');
		$mail->setLabel('mail: ')
			 ->setRequired();
			 // ->addValidator('EmailAddress');

		$password = new Zend_Form_Element_Password('password');
		$password->setLabel('Lösenord: ')
				 ->setRequired();

		$login = new Zend_Form_Element_Submit('login');
		$login->setLabel('Login: ');


		$this->setName('login')
			 ->setMethod('post')
			 ->setAction('/authentication/login') /* Zend_Controller_Front::getInstance()->getBaseUrl() */
			 ->addElements(array($mail, $password, $login));
	}
}