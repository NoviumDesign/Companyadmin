<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');

    	// delivery dates
    	$select = $db->select()
                     ->from('orders', array('orders.delivery_date', 'COUNT(*) AS orders'))
                     ->group('COALESCE(orders.delivery_date, 0) - MOD(COALESCE(orders.delivery_date, 0), 24*60*60)')
                     ->where('orders.delivery = "completed" OR orders.delivery = "approved"')
                     ->where('orders.business = ?', $_SESSION['business']);
        $this->view->deliveryDates = $db->fetchAll($select);
        // TODO
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

        // mail
        $select = $db->select()
                     ->from('customers', array('DISTINCT(mail) AS mail'))
                     ->where('mail <> ""')
                     ->where('business = ' . $_SESSION['business'])
                     ->order('mail DESC');
        $result = $db->fetchAll($select);

        $mails = array();
        foreach($result as $i) {
            $mails[] = $i['mail'];
        }
        $this->view->numMails = count($mails);
        $this->view->mails = join($mails, ', ');

    }
}

