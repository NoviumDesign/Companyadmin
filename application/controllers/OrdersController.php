<?php

class OrdersController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('orders', array('order_id', 'delivery_date', 'status', 'delivery', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('businesses', 'orders.business = businesses.business_id', array('business', 'business_id'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', array('name', 'customer_id'));

        // if "all"
        $business = $this->_request->getParam('business');
        if($business == 'all') {
            $this->view->showAll = true;
        } else {
            $business = (int)$business;
            $select->where('orders.business = ' . $business);
        }

        // fetch data
        $orders = $db->fetchAll($select);
        $this->view->orders = $orders;

        // empty so redirect
        if(!count($orders)) {
            $this->_redirect('/orders/all');
        }

        // custom fields
        if(!$showAll && $orders[0]['business_id']) {
            $select = $db->select()
                         ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                         ->where('business_id = ' . $orders[0]['business_id']);

            $customs = $db->fetchAll($select);
            $this->view->customs = $customs;
        }

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'order', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}