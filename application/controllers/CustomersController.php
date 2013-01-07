<?php

class CustomersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        // customers
        $select = $db->select()
                     ->from('customers', array('customer_id', 'name', 'type', 'registered', 'phone', 'mail'))
                     ->where('customers.business = ' . $_SESSION['business']);
        $customers = $db->fetchAll($select);

        $this->view->customers = $customers;

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'customer', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}