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
		$this->add(new Zend_Acl_Resource('customers'));
		$this->add(new Zend_Acl_Resource('customer'));
		$this->add(new Zend_Acl_Resource('businesses'));
		$this->add(new Zend_Acl_Resource('business'));
		$this->add(new Zend_Acl_Resource('invoices'));

		// $this->add(new Zend_Acl_Resource('order', 'add'), 'order');


		// authority
		$this->allow(null, array('error', 'authentication'));

		$this->allow('user', array('index', 'orders', 'order', 'products', 'product', 'customers', 'customer', 'businesses', 'business', 'invoices'));

		// $this->allow('admin', array('add'));		
	}
}