<?php

class CustomersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        // customers
        $select = $db->select()
                     ->from('customers', array('customer_id', 'name', 'type', 'customer_adress', 'zip_code', 'city', 'country', 'phone', 'mail'))
                     ->where('customers.business = ' . $_SESSION['business']);
        $this->view->customers = $db->fetchAll($select);

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}