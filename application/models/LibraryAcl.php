<?php

class Model_LibraryAcl extends Emilk_Acl_Library
{
	public function build()
	{
		// roles
		$this->addRoles(array('none', 'user', 'admin', 'master', 'god'));

		// resources
		$resources = array(
			'error' => 'none',
			
			'authentication' => array
				(
					'login' => 'none',
					'logout' => 'user',
					'business' => 'user'
				),

			'index' => 'user',

			'orders' => 'user',
			'order' => array
				(
					'view' => 'user',
					'add' => 'admin',
					'delete' => 'admin'
				),

			'products' => 'user',
			'product' => array
				(
					'view' => 'user',
					'add' => 'admin',
					'delete' => 'admin'
				),

			'customers' => 'user',
			'customer' => array
				(
					'view' => 'user',
					'add' => 'admin',
					'delete' => 'admin'
				),

			'invoices' => 'user',
			'invoice' => array
				(
					'view' => 'user',
					'add' => 'admin',
					'edit' => 'admin',
					'delete' => 'admin'
				),

			'request' => 'none'

		);
		$this->addResources($resources);

	}
}