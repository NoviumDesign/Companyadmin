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

		$view->headTitle('Companyadmin');
		$view->user = Zend_Auth::getInstance()->getStorage()->read()->mail;
	}

	protected function _initDatabaseConnection() {
		$db = null;

		$company_id = Zend_Auth::getInstance()->getStorage()->read()->company;
		if($company_id) {
			$array = parse_ini_file("../application/companies/" . $company_id . "/config.ini", true);

			$db = new Zend_Db_Adapter_Pdo_Mysql(array(
			    'host'     => $array[db][host],
			    'username' => $array[db][username],
			    'password' => $array[db][password],
			    'dbname'   => $array[db][dbname]
			));
		}

		Zend_Registry::set('db', $db);
	}
}