<?php

class Form_LoginForm extends Emilk_Form
{
	public function build()
	{
		$mail = new Emilk_Form_Element_Text('mail');
		$mail->setAttr('required', '')
			 ->setAttr('autofocus', '')
			 ->setAttr('tabindex', '1')
			 ->setValidation('required', 'This field is required!');

		$password = new Emilk_Form_Element_Password('password');
		$password->setAttr('required', '')
				 ->setAttr('tabindex', '2')
				 ->setValidation('required', 'This field is required!');

		$login = new Emilk_Form_Element_Button('login');
		$login->setAttr('class', 'fr submit')
			  ->setValue('submit')
			  ->setText('Login');

		$this->setAttr('method', 'post')
			 ->setAttr('action', '/authentication/login')
			 ->add(array(
				 $mail,
				 $password,
				 $login
			 ));
	}
}