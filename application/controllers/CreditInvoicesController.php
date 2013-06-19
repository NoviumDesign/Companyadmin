<?php

class CreditInvoicesController extends Zend_Controller_Action
{  
    public function viewAction()
    {
    	$db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($paid) = $parameters->get();
        
        // select
        $select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'status', 'discount'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name', 'customer_id'))
                     ->where('invoices.type = "credit-invoice"')
                     ->where('invoices.business = ' . $_SESSION['business']);

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