<?php

class Form_AddUserForm extends Emilk_Form
{
	public function build()
	{
		$db = Zend_Registry::get('db');

		// select businesses
		$select = $db->select()
					 ->from('businesses', array('business_id', 'business'))
					 ->order('business ASC');
		$this->businesses = $db->fetchAll($select);

		// businesses
		$businesses = array();
		foreach($this->businesses as $business) {

			$businesses[$business['business_id']] = new Emilk_Form_Element_Checkbox('access[' . $business['business_id'] . ']');
			$businesses[$business['business_id']]->addChoises(array(
													'permitted'
												 ));

		}

		$name = new Emilk_Form_Element_Text('name');
		$name->setAttr('class', 'autocomplete')
			 ->setAttr('required', '');

		$mail = new Emilk_Form_Element_Text('mail');
		$mail->setAttr('class', 'autocomplete')
			 ->setAttr('required', '');

		$password = new Emilk_Form_Element_Password('password');
		$password->setAttr('class', 'autocomplete')
			 	 ->setAttr('required', '');

		$role = new Emilk_Form_Element_Radio('role');
		$role->setAttr('required', '')
			 ->addChoises(array(
				'user',
				'admin',
				'master'
			 ));

		$addUser = new Emilk_Form_Element_Button('addUser');
		$addUser->setAttr('class', 'submit green')
				->setValue('submit')
				->setText('Add user');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/user/add')
			 ->add(array(
			 	$name,
			 	$mail,
			 	$role,
			 	$password,
			 	$addUser
			 ))
			 ->add($businesses);
	}
}