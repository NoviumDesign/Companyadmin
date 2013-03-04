<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');

    	// delivery dates
    	$select = $db->select()
                     ->from('orders', array('orders.delivery_date', 'COUNT(orders.order_id) AS orders'))
                     ->joinLeft('items', 'items.order = orders.order_id', 'SUM(items.quantity) AS items')
                     ->group('COALESCE(orders.delivery_date, 0) - MOD(COALESCE(orders.delivery_date, 0), 24*60*60)')
                     ->where('orders.business = ' . $_SESSION['business']);
        $this->view->deliveryDates = $db->fetchAll($select);
        // TODO
        // delivery != requested
        // no old orders


        // all ordered products
        $select = $db->select()
                     ->from('products', array('product_id', 'product'))
                     ->joinLeft('items', 'items.product = products.product_id', 'SUM(items.quantity) AS quantity')
                     ->group('products.product_id')
                     ->where('items.invoice = 0')
                     ->where('products.business = ' . $_SESSION['business']);
        $this->view->orderedProducts = $db->fetchAll($select);
        // TODO
        // status == active

        // mail
        $select = $db->select()
                     ->from('customers', array('DISTINCT(mail) AS mail'))
                     ->where('mail <> ""')
                     ->where('business = ' . $_SESSION['business'])
                     ->order('mail DESC');
        $result = $db->fetchAll($select);

        $mails = [];
        foreach($result as $i) {
            $mails[] = $i['mail'];
        }
        $this->view->numMails = count($mails);
        $this->view->mails = join($mails, ', ');

    }
}

