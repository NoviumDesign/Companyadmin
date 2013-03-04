<?php

class CrsController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($completed) = $parameters->get();

        $select = $db->select()
                     ->from('crs', array('crs_id', 'status', 'date', 'task'))
                     ->joinLeft('customers', 'crs.customer = customers.customer_id', array('name', 'customer_id'))
                     ->where('crs.business = "' . $_SESSION['business'] . '"');

		if($completed == 'completed') {
            $this->view->completed = true;

            $select->where('crs.status = "completed"');
        } else {
            $select->where('crs.status = "active"');
        }

        $crs = $db->fetchAll($select);

        $this->view->crs = $crs;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}

