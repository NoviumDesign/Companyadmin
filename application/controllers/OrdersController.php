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

        // fetch data
        $select = $db->select()
                     ->from('orders', '*')
                     ->joinLeft('types', 'orders.type = types.type_id', 'type');

        $result = $db->fetchAll($select);

		$this->view->orders = $result;

        // link to order/add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'order', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}