<?php

class DeliveriesController extends Zend_Controller_Action
{
    public function init()
    {
    }
    
    public function viewAction()
    {
    	$db = Zend_Registry::get('db');

		$today = strtotime(date('Y-m-d'));
		$tomorrow = $today + 24*60*60;

		$select = $db->select()
	                 ->from('orders', array('order_id', 'order_number', 'orders.delivery_date', 'delivery_adress', 'status', 'notes'))
	                 ->joinLeft('customers', 'customers.customer_id = orders.customer', array('customer_id', 'name'))
	                 ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) AS items')
	                 ->group('orders.order_id')
	                 ->where('orders.business = ' . $_SESSION['business'])
	                 ->where('orders.delivery_date >= "' . $today . '"')
	                 ->where('orders.delivery_date < "' . $tomorrow . '"')
	                 ->where('orders.delivery <> "requested"');
	    $this->view->deliveries = $db->fetchAll($select);

    }
    
}