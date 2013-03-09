<?php

class Emilk_Request_Parameters
{
	public $parameters = array();

	function __construct()
	{
		$controller = Zend_Controller_Front::getInstance()->getRequest()->getControllerName();
		$action = Zend_Controller_Front::getInstance()->getRequest()->getActionName();

		$path = parse_url($_SERVER['REQUEST_URI']);//['path'];
		$path = $path['path'];

		$parameters =  substr(str_replace('/' . $controller . '/' . $action, '', $path), 1);

		$parameters = explode('/', $parameters);

		if(count($parameters) > 1) {
			$this->parameters = $parameters;
		} else {
			$this->parameters[0] = $parameters[0];
		}
    }

    public function get()
    {
    	return $this->parameters;
    }
}