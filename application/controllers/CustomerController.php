<?php

class CustomerController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        $id = $this->_request->getParam('id');

        // customer
        $select = $db->select()
                     ->from('customers', '*')
                     ->where('customer_id = ' . $id);

        $customer = $db->fetchAll($select);
        $this->view->customer = $customer[0];
    }
}