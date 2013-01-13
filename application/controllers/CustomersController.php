<?php

class CustomersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        // customers
        $select = $db->select()
                     ->from('customers', array('customer_id', 'name', 'type', 'customer_adress', 'phone', 'mail'))
                     ->where('customers.business = ' . $_SESSION['business'] . ' AND customers.registered = "true"');
        $registeredCustomers = $db->fetchAll($select);

        $select = $db->select()
                     ->from('customers', array('customer_id', 'name', 'type', 'customer_adress', 'phone', 'mail'))
                     ->where('customers.business = ' . $_SESSION['business'] . ' AND customers.registered = "false"');
        $noneRegisteredCustomers = $db->fetchAll($select);

        // pass to view
        if(count($registeredCustomers) > 0) {
            $this->view->registeredCustomers = $registeredCustomers;
        }
        if(count($noneRegisteredCustomers) > 0) {
            $this->view->noneRegisteredCustomers = $noneRegisteredCustomers;
        }


        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'customer', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}