<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload() {
		$modelLoader = new Zend_Application_Module_Autoloader(array(
			'namespace' => '',
			'basePath'	=> APPLICATION_PATH
		));

		return $modelLoader;
	}

	protected function _initLibraryAcl() {
		$acl = new Model_LibraryAcl;
		$auth = Zend_Auth::getInstance();
		$fc = Zend_Controller_Front::getInstance();
		$fc->registerPlugin(new Plugin_AccessCheck($acl, $auth));
	}

	protected function _initViewHelpers() {
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		$view->headTitle('123');
	}

}