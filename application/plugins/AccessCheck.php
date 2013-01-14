<?php

class Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{
	private $acl = null;
	private $role = null; 

	public function __construct($acl, $role) {
		$this->acl = $acl;
		$this->role = $role;
	}

	public function preDispatch(Zend_Controller_Request_Abstract $request) {
		$controller = $request->getControllerName();
		$action = $request->getActionName();


		if(!isset($this->role)) {
			$this->role = 'none';
		}

		if(!$this->acl->access($this->role, $controller, $action)) {
			// $request->setControllerName('authentication')
			// 		->setActionName('logout');
		}
		
	}
}