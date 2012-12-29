<?php

class Model_LibraryAcl extends Zend_Acl
{
	public function __construct() {
		// roles
		$this->addRole(new Zend_Acl_Role('user'));
		$this->addRole(new Zend_Acl_Role('admin'), 'user');
		$this->addRole(new Zend_Acl_Role('master'), 'admin');
		$this->addRole(new Zend_Acl_Role('god'), 'master');


		// controllers
		$this->add(new Zend_Acl_Resource('error'));
		$this->add(new Zend_Acl_Resource('authentication'));
		$this->add(new Zend_Acl_Resource('index'));
		$this->add(new Zend_Acl_Resource('orders'));
		$this->add(new Zend_Acl_Resource('order'));
		$this->add(new Zend_Acl_Resource('products'));
		$this->add(new Zend_Acl_Resource('product'));

		// $this->add(new Zend_Acl_Resource('order', 'add'), 'order');


		// authority
		$this->allow(null, array('error', 'authentication'));

		$this->allow('user', array('index', 'orders', 'order', 'products', 'product'));

		// $this->allow('admin', array('add'));		
	}
}