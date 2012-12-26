<?php

class OrdersController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function listAction()
    {
		$db = Zend_Registry::get('db');

		$sql = 'SELECT * FROM orders';
 
		$result = $db->fetchAll($sql, 2);

		$this->view->orders = $result;
    }


}

