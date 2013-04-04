<?php

class AjaxController extends Zend_Controller_Action
{
    public function init()
    {
    	// disable layout and view
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);

        $acl = new Model_LibraryAcl;
        $this->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
    
    public function customerAction()
    {
        $db = Zend_Registry::get('db');
    	$name = $_POST['name'];

        $select = $db->select()
                     ->from('customers', array('name as label', 'customer_id as value'))
                     ->where('customers.business="' . $_SESSION['business'] . '"')
                     ->where('customers.name LIKE ?', '%' . $name . '%');
        $customers = $db->fetchAll($select);

        foreach($customers as $key => $value) {
            $customers[$key]['label'] = html_entity_decode($customers[$key]['label'], ENT_QUOTES, 'UTF-8');
        }

        echo json_encode($customers);

    }

    public function orderstatusAction()
    {
        $db = Zend_Registry::get('db');

        $orderId = $_POST['id'];
        $status = $_POST['status'];

        // update order
        $table = new Model_Db_Orders(array('db' => $db));
        $table->update(array(
                'status' => $status
            ),
            'order_id = ' . $orderId . ' AND  business = ' . $_SESSION['business']
        );

        echo $status;
    }

    public function deliverystatusAction()
    {
        $db = Zend_Registry::get('db');

        $orderId = $_POST['id'];
        $status = $_POST['status'];

        // update order
        $table = new Model_Db_Orders(array('db' => $db));
        $table->update(array(
                'delivery' => $status
            ),
            'order_id = ' . $orderId . ' AND  business = ' . $_SESSION['business']
        );

        echo $status;
    }

    public function invoicestatusAction()
    {
        $db = Zend_Registry::get('db');

        $invoiceId = $_POST['id'];
        $status = $_POST['status'];

        // update invoice
        $table = new Model_Db_Invoices(array('db' => $db));
        $table->update(array(
                'status' => $status
            ),
            'invoice_id = ' . $invoiceId . ' AND  business = ' . $_SESSION['business']
        );

        echo $status;
    }

    public function crstatusAction()
    {
        $db = Zend_Registry::get('db');

        $crId = $_POST['id'];
        $status = $_POST['status'];

        // update invoice
        $table = new Model_Db_Crs(array('db' => $db));
        $table->update(array(
                'status' => $status
            ),
            'crs_id = ' . $crId . ' AND  business = ' . $_SESSION['business']
        );

        echo $status;
    }





    public function carrierAction()
    {
        $db = Zend_Registry::get('db');
        $dDb = Zend_Db_Table::getDefaultAdapter();

        $carrier = $_POST['carrier'];
        $orders = $_POST['orders'];

        $where = 'business = ' . $_SESSION['business'] . ' AND ';

        if(!$this->isAdmin) {
            $myId = Zend_Auth::getInstance()->getStorage()->read()->id;
            if($carrier == 0) {
                $where .= ' carrier = ' . $myId . ' AND ';
            } else {
                $carrier = $myId;
                $where .= ' carrier = 0 AND ';
            }
        }

        $updated = [];
        foreach($orders as $order) {
            $table = new Model_Db_Orders(array('db' => $db));
            $check = $table->update(array(
                'carrier' => $carrier
            ), $where . ' order_id = ' . $order);

            if($check) {
                $updated[] += $order;
            }
        }

        $select = $dDb->select()
                      ->from('users', array('id', 'name'))
                      ->where('company = ?', Zend_Auth::getInstance()->getStorage()->read()->company)
                      ->where('id = ?', $carrier);
        $carrier = $dDb->fetchAll($select);

        if(count($carrier)) {
            $carrier = $carrier[0];
        } else {
            $carrier = ['id' => 0, 'name' => ''];
        }

        echo json_encode(['success' => true, 'carrier' => $carrier, 'updated' => $updated]);
    }
}

