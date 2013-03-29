<?php

class DeliveriesController extends Zend_Controller_Action
{
    public function init()
    {
    }
    
    public function viewAction()
    {
    	$db = Zend_Registry::get('db');
    	$dDb = Zend_Db_Table::getDefaultAdapter();

    	$parameters = new Emilk_Request_Parameters();
        list($date) = $parameters->get();

        if($date) {
			$today = strtotime($date);
			$tomorrow = $today + 24*60*60;
			$this->view->date = $date;
        } else {
			$today = strtotime(date('Y-m-d'));
			$tomorrow = $today + 24*60*60;
        }

		$select = $db->select()
	                 ->from('orders', array('order_id', 'order_number', 'orders.delivery_date', 'delivery_adress', 'status', 'notes', 'carrier AS carrierId'))
	                 ->joinLeft('customers', 'customers.customer_id = orders.customer', array('customer_id', 'name'))
	                 ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) AS items')
	                 ->group('orders.order_id')
	                 ->where('orders.business = ' . $_SESSION['business'])
	                 ->where('orders.delivery_date >= "' . $today . '"')
	                 ->where('orders.delivery_date < "' . $tomorrow . '"')
	                 ->where('orders.delivery <> "requested"');
	    $deliveries = $db->fetchAll($select);

	    foreach($deliveries as $key => $delivery) {
	    	$carrierId = $delivery['carrierId'];

	    	$select = $dDb->select()
					  ->from('users', array('name'))
					  ->where('company = ?', Zend_Auth::getInstance()->getStorage()->read()->company)
					  ->where('id = ?', $carrierId);
			$carrier = $dDb->fetchAll($select);

			if(count($carrier)) {
				$deliveries[$key]['carrier'] = $carrier[0]['name'];
			}
	    }

	    $this->view->deliveries = $deliveries;

    }


    
}