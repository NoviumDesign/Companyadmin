<?php

class OrdersController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('orders', array('order_id', 'order_number', 'delivery_date', 'status', 'delivery', 'notes', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', array('name', 'customer_id'))
                     ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) as quantity')
                     ->group('orders.order_id')
                     ->where('orders.business = ' . $_SESSION['business']);
        $orders = $db->fetchAll($select);

        $this->view->orders = $orders;

        //custom fields
        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $_SESSION['business']);
        $customs = $db->fetchAll($select);

        $this->view->customs = $customs;

        // all ordered products
        $select = $db->select()
                     ->from('products', array('product_id', 'product'))
                     ->joinLeft('items', 'items.product = products.product_id', 'SUM(items.quantity) as quantity')
                     ->group('products.product_id')
                     ->where('items.invoice = 0')
                     ->where('products.business = ' . $_SESSION['business']);
        $orderedProducts = $db->fetchAll($select);

        $this->view->orderedProducts = $orderedProducts;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}