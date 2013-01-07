<?php

class OrdersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('orders', array('order_id', 'order_number', 'delivery_date', 'status', 'delivery', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', array('name', 'customer_id'))
                     ->where('orders.business = ' . $_SESSION['business']);
        $orders = $db->fetchAll($select);

        $this->view->orders = $orders;

        //custom fields
        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $_SESSION['business']);
        $customs = $db->fetchAll($select);

        $this->view->customs = $customs;

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'order', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}