<?php

class Model_LibraryAcl extends Zend_Acl
{
	public function __construct() {
		// roles
		$this->addRole(new Zend_Acl_Role('user'));
		$this->addRole(new Zend_Acl_Role('admin'), 'user');
		$this->addRole(new Zend_Acl_Role('master'), 'admin');
		$this->addRole(new Zend_Acl_Role('god'), 'master');


		// resources
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('error'));

		$this->add(new Zend_Acl_Resource('authentication'));
		$this->add(new Zend_Acl_Resource('login', 'authentication'));
		$this->add(new Zend_Acl_Resource('logout', 'authentication'));

		$this->add(new Zend_Acl_Resource('orders'));

		$this->add(new Zend_Acl_Resource('order'));
		$this->add(new Zend_Acl_Resource('add'), 'order');


		// authority
		$this->allow(null, array('authentication', 'error'));

		$this->allow('user', array('index', 'orders', 'logout'));
		$this->deny('user', 'login');

		$this->allow('admin', 'order');		
	}
}