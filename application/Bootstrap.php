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

	protected function _initAcl() {
		$acl = new Model_LibraryAcl;
		
		if(isset(Zend_Auth::getInstance()->getStorage()->read()->role)) {
			$role = Zend_Auth::getInstance()->getStorage()->read()->role;
		} else {
			$role = null;
		}

		$fc = Zend_Controller_Front::getInstance();
		$fc->registerPlugin(new Plugin_AccessCheck($acl, $role));
	}

	protected function _initViewHelpers() {
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();

		$view->headTitle('Companyadmin');
		$view->user = Zend_Auth::getInstance()->getStorage()->read();
	}

	protected function _initDatabaseConnection() {

		if(isset(Zend_Auth::getInstance()->getStorage()->read()->company)) {
			$company_id = Zend_Auth::getInstance()->getStorage()->read()->company;
			$config = new Zend_Config_Ini(APPLICATION_PATH . '/companies/' . $company_id . '/config.ini');

			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
			    'host'     => $config->db->host,
			    'username' => $config->db->username,
			    'password' => $config->db->password,
			    'dbname'   => $config->db->dbname
			));

			Zend_Registry::set('db', $db);
		}
	}
}