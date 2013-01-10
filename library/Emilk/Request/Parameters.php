<?php

class Emilk_Request_Parameters
{
	public $parameters = array();

	function __construct()
	{
		$controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

		$path = parse_url($_SERVER['REQUEST_URI'])['path'];

		$parameters =  str_replace('/' . $controller . '/' . $action . '/', '', $path);

		if(is_array($parameters)) {
			$this->paramaters = explode('/', $parameters);
		} else {
			$this->parameters[0] = $parameters;
		}
    }

    public function get()
    {
    	return $this->parameters;
    }
}