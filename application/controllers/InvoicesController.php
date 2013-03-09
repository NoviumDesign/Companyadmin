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
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'due', 'status', 'discount'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name', 'customer_id'))
                     ->where('invoices.business = ' . $_SESSION['business']);

        if($paid == 'paid') {
            $this->view->paid = 'paid';

            $select->where('invoices.status = "paid"');
        } else {
            $select->where('invoices.status = "unpaid"');
        }

        $invoices = $db->fetchAll($select);

        $totSums = array();
        foreach($invoices as $invoice) {
            $invoiceId = $invoice['invoice_id'];

            $select = $db->select()
                         ->from('items', 'quantity')
                         ->joinLeft('prices', 'prices.price_id=items.price', array('price', 'vat'))
                         ->where('items.invoice = "' . $invoiceId . '"');
            $items = $db->fetchAll($select);

            $totSum = 0;
            foreach($items as $item) {
                $totSum += (float)$item['quantity']*(float)$item['price'];
            }

            $totVat = 0;
            $discount = (float)$invoice['discount'];
            foreach($items as $item) {
                $price = (float)$item['price'];
                $quantity = (float)$item['quantity'];
                $vat = (0.01*(float)$item['vat']);

                $totVat += $quantity*$price*(1 - $discount/$totSum)*$vat;
            }

            $totSums[$invoiceId] = round($totSum + $totVat - $discount);
        }

        $this->view->totSums = $totSums;
        $this->view->invoices = $invoices;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}