<?php

class IndexController extends Zend_Controller_Action
{
    
    public function indexAction()
    {
        $db = Zend_Registry::get('db');

    	// order dates
    	$select = $db->select()
                     ->from('orders', array('orders.delivery_date', 'COUNT(orders.order_id) AS orders'))
                     ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) AS items')
                     ->group('COALESCE(orders.delivery_date, 0) - MOD(COALESCE(orders.delivery_date, 0), 24*60*60)')
                     ->where('orders.business = ' . $_SESSION['business']);
        $this->view->orderDates = $db->fetchAll($select);


    }
}

