<?php

class AjaxController extends Zend_Controller_Action
{
    public function init()
    {
    	// disable layout and view
        $this->_helper->layout()->disableLayout(); 
        $this->_helper->viewRenderer->setNoRender(true);
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
}

