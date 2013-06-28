<?php

class RequestOrderController extends Zend_Controller_Action
{
	public function init()
    {
        $this->_helper->layout()->disableLayout();

        // parse parameters
        $parameters = new Emilk_Request_Parameters();
        list($this->companySecret, $this->businessSecret) = $parameters->get();

        $result = $this->dbConnection();

        $this->businessId = $result[0]['business_id'];
        $this->view->color = $result[0]['company_color'];
        $this->view->business = $result[0]['business'];
        $this->companySite = $result[0]['company_site'];
        $this->view->companySite = $result[0]['company_site'];
        $this->path = $this->companySecret . '/' . $this->businessSecret;
        $this->view->formAction = $this->companySecret . '/' . $this->businessSecret;
        $this->delivery = $result[0]['delivery'];
        $this->view->delivery = $result[0]['delivery'];
        $this->view->customFields = array_filter(array(
            1 => $result[0]['custom_field_1'],
            2 => $result[0]['custom_field_2'],
            3 => $result[0]['custom_field_3']
        ));
        $this->orderMailTitle = $result[0]['order_mail_title'];
        $this->orderMailContent = nl2br($result[0]['order_mail_content']);
        $this->companyMail = $result[0]['company_mail'];
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
                       ->from('businesses', array(
                        'business_id',
                        'company_color',
                        'business',
                        'company_site',
                        'delivery',
                        'custom_field_1',
                        'custom_field_2',
                        'custom_field_3',
                        'order_mail_title',
                        'order_mail_content',
                        'company_mail'
                        ))
                       ->where('businesses.business_secret = "' . $this->businessSecret . '"');
        $result = $this->db->fetchAll($select);

        return $result;
    }

    // for treat
    private function process($val)
    {
            if (is_array($val)) {
                return '';
            }

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

    private function selectOrderNumber()
    {
        $select = $this->db->select()
                       ->from('orders', '(COALESCE(MAX(order_number), 0) + 1) as orderNumber')
                       ->where('orders.business =' . $this->businessId);
        $result = $this->db->fetchAll($select);
        $orderNumber = $result[0]['orderNumber'];

        return $orderNumber;
    }

    private function selectProduct($productSecret)
    {
        $select = $this->db->select()
                       ->from('products', array('product_id', 'product_secret', 'product'))
                       ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
                       ->where('products.business = ?', $this->businessId)
                       ->where('products.product_secret = ?', $productSecret);
        $products = $this->db->fetchAll($select);

        return $products[0];
    }

	public function startAction()
	{
		$db = $this->db;
		$business = $this->businessId;

		$select = $db->select()
                     ->from('products', array('product', 'product_secret'))
                     ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
                     ->where('products.business = ?', $business)
                     ->where('products.status <> "deleted"')
                     ->where('products.status <> "out of stock"')
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->view->products = $result;
	}

    public function addAction()
    {
        $this->_helper->viewRenderer->setNoRender(true);

        $db = $this->db;
        $business = $this->businessId;

        $data = $this->treat($_POST);
        $items = $this->treat($_POST['items']);
        
        if(isset($_POST['customFields'])) {
            $customFields = $this->treat($_POST['customFields']);
        }

        if( 
            !(isset($data['name']) &&
            isset($data['type']) &&
            ($data['type'] == 'private' || $data['type'] == 'company')&&
            isset($data['phone']) &&
            isset($data['email']) &&
            (isset($data['adress']) || isset($data['box'])) &&
            isset($data['zip']) &&
            isset($data['city']) &&
            isset($data['country']) &&
            count($items))
        ) {
            echo 'error';
            exit();
        }

        $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);

        // insert new customer
        $table = new Model_Db_Customers(array('db' => $db));
        $orderCustomer = $table->insert(array(
            'registered' => 'false',
            'customer_secret' => $secret,
            'business' => $business,
            'name' => $data['name'],
            'reference' => (isset($data['reference'])? $data['reference']: null),
            'type' => $data['type'],
            'mail' => $data['email'],
            'phone' => $data['phone'],
            'customer_adress' => (isset($data['adress'])? $data['adress']: null),
            'box' => (isset($data['box'])? $data['box']: null),
            'zip_code' => $data['zip'],
            'city' => $data['city'],
            'country' => $data['country']
        ));

        // insert order
        $table = new Model_Db_Orders(array('db' => $this->db));
        $orderId = $table->insert(array(
            'order_secret' => $secret,
            'order_number' => $this->selectOrderNumber(),
            'date' => time(),
            'business' => $business,
            'delivery' => ($this->delivery == 'true'? 'requested': 'none'),
            'delivery_adress' => ($this->delivery == 'true'? $data['deliveryAdress']: null),
            'delivery_date' =>  ($this->delivery == 'true'? strtotime($data['deliveryDate'] . (isset($data['deliveryTime'])? ' ' . $data['deliveryTime']: '')): null),
            'status' => 'new',
            'customer' => $orderCustomer,
            'notes' => (isset($data['notes'])? $data['notes']: null),
            'custom_1' => (isset($customFields[1])? $customFields[1]: null),
            'custom_2' => (isset($customFields[2])? $customFields[2]: null),
            'custom_3' => (isset($customFields[3])? $customFields[3]: null)
        ));

        // items
        foreach($items as $productSecret => $quantity) {

            $products = $this->selectProduct($productSecret);
            $product = $products;

                // insert
            $table = new Model_Db_Items(array('db' => $this->db));
            $table->insert(array(
                    'product' => $product['product_id'],
                    'order' => $orderId,
                    'quantity' => $quantity,
                    'price' => $product['price']
            ));
        }


        include('../application/configs/smtp_mail.php');

        $transport = new Zend_Mail_Transport_Smtp('smtp.mandrillapp.com', $config);

        // mail
        $mail = new Zend_Mail('UTF-8');
        $mail->setBodyText(html_entity_decode($this->orderMailContent, ENT_QUOTES, 'UTF-8'));
        $mail->setFrom($this->companyMail, $this->companySite);
        $mail->addTo($data['email'], $data['name']);
        $mail->setSubject(html_entity_decode($this->orderMailTitle, ENT_QUOTES, 'UTF-8'));
        $mail->send($transport);

        $this->_redirect('/request-order/complete/' . $this->path);
    }

    public function completeAction()
    {
    }
}