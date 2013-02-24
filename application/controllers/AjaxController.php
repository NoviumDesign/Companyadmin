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
}

