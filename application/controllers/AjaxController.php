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
                     ->where('customers.name LIKE ?', '%' . $name . '%');
        $customers = $db->fetchAll($select);

        echo json_encode($customers);

    }
}

