<?php

class Model_LibraryAcl extends Zend_Acl
{
	public function __construct() {
		// roller
		$this->addRole(new Zend_Acl_Role('user'));
		$this->addRole(new Zend_Acl_Role('admin'), 'user');


		// platser
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('error'));

		$this->add(new Zend_Acl_Resource('authentication'));
		$this->add(new Zend_Acl_Resource('login', 'authentication'));
		$this->add(new Zend_Acl_Resource('logout', 'authentication'));

		$this->add(new Zend_Acl_Resource('orders'));
		// $this->add(new Zend_Acl_Resource('login', 'authentication'));


		// rättigheter
		$this->allow(null, array('authentication', 'error'));

		$this->allow('user', array('index', 'orders', 'logout'));
		$this->deny('user', 'login');
	}
}