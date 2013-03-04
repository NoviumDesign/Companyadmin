<?php

class OrdersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($completed) = $parameters->get();

        // select
        $select = $db->select()
                     ->from('orders', array('order_id', 'order_number', 'delivery_date', 'status', 'delivery', 'notes', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', array('name', 'customer_id'))
                     ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) as quantity')
                     ->group('orders.order_id')
                     ->where('orders.business = ' . $_SESSION['business']);

        if($completed == 'completed') {
            $this->view->completed = true;

            $select->where('(orders.status = "completed" OR orders.status = "invoice")');
        } else {
            $select->where('(orders.status = "new" OR orders.status = "active")');
        }
        
        $orders = $db->fetchAll($select);

        $this->view->orders = $orders;

        //custom fields
        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $_SESSION['business']);
        $customs = $db->fetchAll($select);

        $this->view->customs = $customs;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}