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
			'favicon.ico' => 'none',	// AccessCheck fix
			
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

			'ajax' => 'user',

			'request' => 'none',

			'pdf' => 'none',

			'system' => 'admin',

			'users' => 'admin',
			'user' => array
				(
					'add' => 'admin',
					'view' => 'user',
					'delete' => 'admin'
				),

			'businesses' => 'master',
			'business' => 'master',

			'deliveries' => 'user',

			'crs' => 'user'


		);
		$this->addResources($resources);

	}
}