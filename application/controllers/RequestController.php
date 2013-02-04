<?php

class RequestController extends Zend_Controller_Action
{
    private $sessionName = '1jf83gd7848hfg834hgf8s834hd834h3458dfh328fhas89h';
    private $companySecret;
    private $businessSecret;
    private $token;
    private $db;
    private $businessId;
    private $output = array();

    public function init()
    {
        // disable layout and view
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);

        // check action
        $action = $this->getRequest()->getActionName();
        if($action != 'token') {

            // parse parameters
            $parameters = new Emilk_Request_Parameters();
            list($this->companySecret, $this->businessSecret, $this->token) = $parameters->get();

            // parameter check
            
            if(!($this->companySecret && $this->businessSecret && $this->token)) {
                $this->output['error'] = 'parameters';
                exit();
            }

            // $token = $_SESSION[$this->sessionName];
            // if($token != $this->token) {
            //     $this->output['error'] = 'token';
            //     exit();
            // }

            // connect to db
            $this->dbConnection();
        }
    }

    function __destruct()
    {
        // generate new token
        $this->output['token'] = $this->generateToken();

        // output for every action
        echo json_encode($this->output);
    }

    public function tokenAction()
    {
    }

    public function dataAction()
    {
        // products data
        $products = $this->selectProducts();

        // remove product_id from array. same mselect method is used elsewhere and product_id is there necessary 
        foreach($products as $key => $value) {
            unset($products[$key]['product_id']);
        }

        // custom fields
        $customFields = $this->selectCustomFields();

        $this->output['data']['products'] = $products;
        $this->output['data']['customFields'] = $customFields;

        // success
        $this->output['success'] = true;
    }

    public function customerAction()
    {   
        $customerSecret = $this->treat($_POST['try']);

        // select customer
        $customer = $this->selectCustomer($customerSecret);

        // remove customer_id so it wont be sent to user
        unset($customer['customer_id']);

        $this->output['customer'] = $customer;
    }

    public function postAction()
    {
        // get available custom fields
        $_customFields = $this->selectCustomFields();

        // custom fields
        $customFields = $this->treat($_POST['customFields']);
        $i = 1;
        foreach($_customFields as $key => $value) {
            if(!$value) {
                $customFields[$i] = null;
            }
            $i++;
        }

        // delivery
        $order = $this->treat($_POST['order']);
        if(isset($order['delivery'])) {

            if($order['delivery'] == 'requested') {
                if(!(isset($order['deliveryAdress']) && isset($order['deliveryDate']))) {
                    $this->output['error'] =  'delivery';
                }
            } elseif($order['delivery'] == 'none') {
                $order['deliveryAdress'] = null;
                $order['deliveryDate'] = null;
            } 
        }

        // items
        $items = $this->treat($_POST['products']);
        $i = 0;
        foreach($items as $quantity) {
            // prevent item quantity equals a string
            if((float)$quantity > 0) {
                $i++;
            }
        }
        if($i == 0) {
            $this->output['error'] = 'product';
        }

        // get customer
        $customer = $this->treat($_POST['customer']);
        if(isset($customer['try'])) {
            // allready a user
            $_orderCustomer = $this->selectCustomer($customer['try']);

            if($_orderCustomer) {
                $orderCustomer = $_orderCustomer['customer_id'];
            }
        }
        if( 
            (!isset($orderCustomer)) && // if try was false, forgot to erase
            isset($customer['name']) &&
            isset($customer['phone']) &&
            isset($customer['mail'])
        ) {   
            $orderCustomer = false;
            // test customer secret

            // length over 5 <------------------------------------------------------------------------------------------------------------------OBS
            if(strlen(trim($_POST['customer']['secret'])) < 5) {
                $this->output['error'] =  'secret length';
            } else if($this->selectCustomer($customer['secret'])) {
                $this->output['error'] =  'secret';
            }
        }
        if(!isset($orderCustomer)) {
            $this->output['error'] = 'customer';
        }


        if(!isset($this->output['error'])) {
            $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);

            if(!$orderCustomer) {
                // insert new customer
                $table = new Model_Db_Customers(array('db' => $this->db));
                $orderCustomer = $table->insert(array(
                    'registered' => 'false',
                    'customer_secret' => (isset($customer['secret'])? md5($customer['secret']): null),
                    'business' => $this->businessId,
                    'name' => $customer['name'],
                    'type' => (isset($customer['type'])? $customer['type']: null),
                    'mail' => $customer['mail'],
                    'phone' => $customer['phone'],
                    'customer_adress' => (isset($customer['invoiceAdress'])? $customer['invoiceAdress']: null),
                    'box' => (isset($customer['box'])? $customer['box']: null),
                    'zip_code' => (isset($customer['zipCode'])?$customer['zipCode'] : null),
                    'city' => (isset($customer['city'])?$customer['city'] : null),
                    'country' => (isset($customer['country'])?$customer['country'] : null),
                    'notes' => (isset($customer['notes'])? $customer['notes']: null)
                ));
            }

            // insert
            $table = new Model_Db_Orders(array('db' => $this->db));
            $orderId = $table->insert(array(
                    'order_secret' => $secret,
                    'order_number' => $this->selectOrderNumber(),
                    'date' => time(),
                    'business' => $this->businessId,
                    'delivery' => $order['delivery'],
                    'delivery_adress' => (isset($order['deliveryAdress'])? $order['deliveryAdress']: null),
                    'delivery_date' =>  (isset($order['deliveryDate'])? strtotime($order['deliveryDate']): null),
                    'status' => 'active',
                    'customer' => $orderCustomer, // create customer
                    'notes' => (isset($order['deliveryNotes'])? $order['deliveryNotes']: null),
                    'custom_1' => (isset($customFields[1])? $customFields[1]: null),
                    'custom_2' => (isset($customFields[2])? $customFields[2]: null),
                    'custom_3' => (isset($customFields[3])? $customFields[3]: null)
                ));

            // create items
            foreach($items as $productSecret => $quantity) {

                    $products = $this->selectProducts($productSecret);
                    $product = $products[0];

                    // insert
                $table = new Model_Db_Items(array('db' => $this->db));
                $table->insert(array(
                        'product' => $product['product_id'],
                        'order' => $orderId,
                        'quantity' => $quantity,
                        'price' => $product['price']
                ));
            }

            $this->output['success'] = true;

            $mail = new Zend_Mail('UTF-8');
            $mail->setBodyText(
                'Hej!

                Det här är en bekräftelse på att vi mottagit din order.

                Tack för att du väljer att låta Vallaservice stå för prepareringen av dina skidor. Om du har några frågor är du välkommen att ta kontakt med oss. Svara på detta mail eller ring oss på 0280-200 30.

                Vi ser fram emot att ta hand om dina skidor i samband med det lopp du valt att åka.

                Teamet på Vallaservice.se'
                );
            $mail->setFrom('info@vallaservice.se', 'Vallaservice.se');
            $mail->addTo($customer['mail'], $customer['name']);
            $mail->setSubject('Orderbekräftelse');
            $mail->send();

        }
    }

    // for treat
    private function process($val)
    {
            $trimmed = trim($val);
            $html = htmlentities($trimmed);

            return $html;
    }
    private function treat($array)
    {
        // array or string
        if(is_array($array)){
            $return = array();
            foreach($array as $key => $value) {
                // so that isset(value) will enough validation
                if($this->process($value)) {
                    $return[$key] = $this->process($value);
                }
            }

            return $return;
        } else {
            return $this->process($array);
        }
    }

    private function generateToken()
    {
        // create random string
        $str = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $shuffled = str_shuffle($str);

        // assign to session
        $_SESSION[$this->sessionName] = $shuffled;

        // return token which will be outputed
        return $shuffled;
    }

    private function dbConnection()
    {
        // select company
        $db = Zend_Db_Table::getDefaultAdapter();
        $select = $db->select()
                     ->from('companies', 'company_id')
                     ->where('companies.company_secret = "' . $this->companySecret . '"');
        $result = $db->fetchAll($select);
        $companyId = $result[0]['company_id'];

        // create company connection
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/companies/' . $companyId . '/config.ini', APPLICATION_ENV);
        $this->db = new Zend_Db_Adapter_Pdo_Mysql(array(
            'host'     => $config->db->host,
            'username' => $config->db->username,
            'password' => $config->db->password,
            'dbname'   => $config->db->dbname
        ));

        // select business
        $select = $this->db->select()
                     ->from('businesses', 'business_id')
                     ->where('businesses.business_secret = "' . $this->businessSecret . '"');
        $result = $this->db->fetchAll($select);
        $this->businessId = $result[0]['business_id'];
    }

    // selects
    private function selectCustomFields()
    {
        $select = $this->db->select()
                       ->from('businesses', array('custom_field_1 as "1"', 'custom_field_2 as "2"', 'custom_field_3 as "3"'))
                       ->where('businesses.business_id = "' . $this->businessId . '"');
        $result = $this->db->fetchAll($select);

        return $result[0];
    }

    private function selectProducts($productSecret = false)
    {
        // extend precision for select
        if($productSecret) {
            $product = ' AND products.product_secret = "' . $productSecret . '"';
        } else {
            $product = '';
        }

        $select = $this->db->select()
                       ->from('products', array('product_id', 'product_secret', 'product'))
                       ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
                       ->where('products.business = ' . $this->businessId . ' AND products.status <> "deleted"' . $product)
                       ->order('product_number ASC');
        $products = $this->db->fetchAll($select);

        return $products;
    }

    private function selectOrderNumber()
    {
        $select = $this->db->select()
                       ->from('orders', '(COALESCE(MAX(order_number), 0) + 1) as orderNumber')
                       ->where('orders.business =' . $this->businessId);
        $result = $this->db->fetchAll($select);
        $orderNumber = $result[0]['orderNumber'];

        return $orderNumber;
    }

    private function selectCustomer($customerSecret)
    {
        $select = $this->db->select()
                       ->from('customers', array('customer_id', 'name'))
                       ->where('customers.business =' . $this->businessId . ' AND customers.customer_secret = "' . md5($customerSecret) . '"');
        $result = $this->db->fetchAll($select);

        // prevent "index undefined notice" if mismatch
        if(isset($result[0])) {
            $customer = $result[0];
        } else {
            $customer = null;
        }

        return $customer;
    }
}