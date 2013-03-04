<?php

class InvoicesController extends Zend_Controller_Action
{  
    public function viewAction()
    {
    	$db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($paid) = $parameters->get();
        
        // select
        $select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'due', 'status'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name', 'customer_id'))
                     ->where('invoices.business = ' . $_SESSION['business']);

        if($paid == 'paid') {
            $this->view->paid = 'paid';

            $select->where('invoices.status = "paid"');
        } else {
            $select->where('invoices.status = "unpaid"');
        }

        $invoices = $db->fetchAll($select);

        $this->view->invoices = $invoices;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}