<?php

class RequestController extends Zend_Controller_Action
{
	private $sessionName = '1jf83gd7848hfg834hgf8s834hd834h3458dfh328fhas89h';

	public function preDispatch()
	{
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function postAction()
    {
    	$output = array();

    	$token = $_SESSION[$this->sessionName];
    	if($token === $_POST['token']) {

    		// when done
    		$output['success'] = true;
    	} else {
    		$output['error'] =  'token';
    	}

    	// generate new token
    	$output['token'] = $this->generateToken();

    	echo json_encode($output);
    }

    public function dataAction()
    {
    	// data about products, order and customer to be used in a form
    	$output = array();

    	$parameters = new Emilk_Request_Parameters();
        list($companyId, $businessId, $tokenUrl) = $parameters->get();

    	if(isset($_SESSION[$this->sessionName]) && isset($tokenUrl)) {

    		$token = $_SESSION[$this->sessionName];
	    	if($token === $tokenUrl) {

				$config = new Zend_Config_Ini(APPLICATION_PATH . '/companies/' . $companyId . '/config.ini');
				$db = new Zend_Db_Adapter_Pdo_Mysql(array(
				    'host'     => $config->db->host,
				    'username' => $config->db->username,
				    'password' => $config->db->password,
				    'dbname'   => $config->db->dbname
				));

	    		// products data
		        $select = $db->select()
		                     ->from('products', array('product_id', 'product'))
		                     ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
		                     ->where('products.business = ' . $businessId . ' AND products.status <> "deleted"')
		                     ->order('product ASC');
		        $products = $db->fetchAll($select);

		        // custom fields
		        $select = $db->select()
		                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
		                     ->where('businesses.business_id = ' . $businessId);
		        $result = $db->fetchAll($select);
		        $customFields = $result[0];

		        $output['data']['products'] = $products;

		        $output['data']['customFields'] = $customFields;


	    		// success
	    		$output['success'] = true;
	    	} else {
	    		$output['error'] =  'token';
	    	}
    	} else {
	    	$output['error'] =  'token';
    	}

    	// generate new token
    	$output['token'] = $this->generateToken();

    	echo json_encode($output);
    }

    public function tokenAction()
    {
    	// recieve token to be used in request

    	echo json_encode(array('token' => $this->generateToken()));
    }

    private function generateToken()
    {
    	$str = 'abcdefghijklmnopqrstuvwxyz0123456789';
    	$shuffled = str_shuffle($str);

    	$_SESSION[$this->sessionName] = $shuffled;

    	return $shuffled;
    }
}