<?php

class Form_EditUserForm extends Emilk_Form
{	
	private $userId;
	public $isAdmin;
	public $role;

	function __construct($userId, $isAdmin, $role)
	{
        parent::__construct();
        
		$this->userId = $userId;
		$this->isAdmin = $isAdmin;
		$this->role = $role;
	}

	public function build()
	{
        $dDb = Zend_Db_Table::getDefaultAdapter();
        $db = Zend_Registry::get('db');

        // user data
        $select = $dDb->select()
                      ->from('users', array('id', 'mail', 'role', 'name'))
                      ->where('users.id = "' . $this->userId . '"');
        list($user) = $dDb->fetchAll($select);

        // access
        if($this->role == 'admin') {
        	$adminId = Zend_Auth::getInstance()->getStorage()->read()->id;
        	$select = $db->select()
                    	 ->from('user_access as admin_access')
                   		 ->joinLeft('businesses', 'admin_access.business = businesses.business_id', array('business_id', 'business'))
                     	 ->joinLeft('user_access', 'user_access.business = businesses.business_id AND user_access.user = "' . $this->userId . '"', 'user as user_access')
        			 	 ->where('admin_access.user = "' . $adminId. '"');
        } else {
        	$select = $db->select()
                    	 ->from('businesses', array('business_id', 'business'))
                     	 ->joinLeft('user_access', 'user_access.business = businesses.business_id AND user_access.user = "' . $this->userId . '"', 'user as user_access');
        }
        $this->businesses = $db->fetchAll($select);

        // businesses
		$businesses = array();
		foreach($this->businesses as $business) {

			$businesses[$business['business_id']] = new Emilk_Form_Element_Checkbox('access[' . $business['business_id'] . ']');
			$businesses[$business['business_id']]->addChoises(array(
													'permitted'
												 ));

			if($business['user_access']) {
				$businesses[$business['business_id']]->setValue('permitted');
			}
		}

		$name = new Emilk_Form_Element_Text('name');
		$name->setAttr('class', 'autocomplete')
			 ->setAttr('required', '')
			 ->setValue($user['name']);

		$mail = new Emilk_Form_Element_Text('mail');
		$mail->setAttr('class', 'autocomplete')
			 ->setAttr('required', '')
			 ->setValue($user['mail']);

		$password = new Emilk_Form_Element_Password('password');
		$password->setAttr('class', 'autocomplete');

		$role = new Emilk_Form_Element_Radio('role');
		$role->setAttr('required', '')
			 ->addChoises(array(
				'user',
				'admin',
				'master'
			 ))
			 ->setValue($user['role']);


		$editUser = new Emilk_Form_Element_Button('editUser');
		$editUser->setAttr('class', 'submit green')
				->setValue('submit')
				->setText('Edit user');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->add(array(
			 	$name,
			 	$mail,
			 	$password,
			 	$editUser
			 ));

		if($this->isAdmin) {
			$this->add($businesses)
				 ->add(array(
			 		$role
				 ));
		}
	}

}