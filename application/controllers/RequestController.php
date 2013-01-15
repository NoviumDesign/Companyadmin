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

        $parameters = new Emilk_Request_Parameters();
        list($companySecret, $businessSecret, $tokenUrl) = $parameters->get();

        if(isset($_SESSION[$this->sessionName]) && isset($tokenUrl) && isset($companySecret) && isset($businessSecret) && isset($tokenUrl)) {

            $token = $_SESSION[$this->sessionName];
            if($token === $tokenUrl) {

                list($businessId, $db) = $this->getBusinessDb($companySecret, $businessSecret);

                // validation for insert
                $valid = true;

                // get available custom fields
                $select = $db->select()
                             ->from('businesses', array('custom_field_1 as "1"', 'custom_field_2 as "2"', 'custom_field_3 as "3"'))
                             ->where('businesses.business_secret = "' . $businessSecret . '"');
                $result = $db->fetchAll($select);
                $_customFields = $result[0];

                // custom fields
                $customFields = $_POST['customFields'];
                $i = 0;
                foreach($_customFields as $key => $value) {
                    if(!$value) {
                        $customFields[$i] = null;
                    }
                    $i++;
                }

                // delivery
                if(isset($_POST['order']['delivery']) && $_POST['order']['delivery'] == 'requested') {
                    if(!isset($_POST['order']['deliveryAdress']) && !isset($_POST['order']['deliveryDate'])) { 
                        $output['error'] =  'data';
                        $valid = false;
                    }
                } elseif(isset($_POST['order']['delivery']) && $_POST['order']['delivery'] == 'none') {
                    $_POST['order']['deliveryAdress'] = null;
                    $_POST['order']['deliveryDate'] = null;
                } else {
                    $output['error'] =  'data';
                    $valid = false;
                }

                $select = $db->select()
                             ->from('orders', '(COALESCE(MAX(order_number), 0) + 1) as orderNumber')
                             ->where('orders.business =' . $businessId);
                $result= $db->fetchAll($select);
                $orderNumber = $result[0]['orderNumber'];



                if(isset($_POST['order']['try'])) {
                    // test user

                } else {
                    // create user
                } else {
                    $valid = false;
                }





                if($valid) {
                    $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);

                    // insert
                    $table = new Model_Db_Orders(array('db' => $db));
                    $orderId = $table->insert(array(
                            'order_secret' => $secret,
                            'order_number' => $orderNumber,
                            'date' => time(),
                            'business' => $businessId,
                            'delivery' => htmlentities($_POST['order']['delivery'], ENT_QUOTES, "UTF-8"),
                            'delivery_adress' => htmlentities($_POST['order']['deliveryAdress'], ENT_QUOTES, "UTF-8"),
                            'delivery_date' => strtotime($_POST['order']['deliveryDate']),
                            'status' => 'active',
                            'customer' => '3', // create customer
                            'notes' => htmlentities($_POST['order']['deliveryNotes'], ENT_QUOTES, "UTF-8"),
                            'custom_1' => htmlentities($customFields[0], ENT_QUOTES, "UTF-8"),
                            'custom_2' => htmlentities($customFields[1], ENT_QUOTES, "UTF-8"),
                            'custom_3' => htmlentities($customFields[2], ENT_QUOTES, "UTF-8") 
                        ));


                    // create items
                    foreach($_POST['products'] as $productSecret => $quantity) {
                        if($quantity > 0) {

                            // get price and productId
                            $select = $db->select()
                                         ->from('products', array('product_id as id', 'price'))
                                         ->where('product_secret = "' . $productSecret . '"');
                            $result= $db->fetchAll($select);
                            $product = $result[0];

                            // insert
                            $table = new Model_Db_Items(array('db' => $db));
                            $table->insert(array(
                                    'product' => $product['id'],
                                    'order' => $orderId,
                                    'quantity' => $quantity,
                                    'price' => $product['price']
                                ));
                        }
                    }

                    $output['success'] = true;

                } else {
                    $output['error'] =  'data';
                }



                // success
            } else {
                $output['error'] =  'token';
            }
        } else {
            $output['error'] =  'parameters';
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
        list($companySecret, $businessSecret, $tokenUrl) = $parameters->get();

    	if(isset($_SESSION[$this->sessionName]) && isset($tokenUrl) && isset($companySecret) && isset($businessSecret) && isset($tokenUrl)) {

    		$token = $_SESSION[$this->sessionName];
	    	if($token === $tokenUrl) {

                list($businessId, $db) = $this->getBusinessDb($companySecret, $businessSecret);
                

	    		// products data
		        $select = $db->select()
		                     ->from('products', array('product_secret', 'product'))
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
	    	$output['error'] =  'parameters';
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

    private function getBusinessDb($companySecret, $businessSecret)
    {
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                     ->from('companies', 'company_id')
                     ->where('companies.company_secret = "' . $companySecret . '"');
        $result = $db->fetchAll($select);
        $companyId = $result[0]['company_id'];


        $config = new Zend_Config_Ini(APPLICATION_PATH . '/companies/' . $companyId . '/config.ini', APPLICATION_ENV);
        $db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => $config->db->host,
            'username' => $config->db->username,
            'password' => $config->db->password,
            'dbname'   => $config->db->dbname
        ));


        $select = $db->select()
                     ->from('businesses', 'business_id')
                     ->where('businesses.business_secret = "' . $businessSecret . '"');
        $result = $db->fetchAll($select);
        $businessId = $result[0]['business_id'];


        if(isset($businessId)) {
            return array($businessId, $db);
        } else {
            return array('you', 'fail');
        }
    }
}