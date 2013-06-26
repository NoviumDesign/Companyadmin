<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        $dDb = Zend_Db_Table::getDefaultAdapter();
        $user = Zend_Auth::getInstance()->getStorage()->read();

        $today = strtotime(date('Y-m-d'));

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


        // new orders
        $select = $db->select()
                     ->from('orders', 'count(*) as num_orders')
                     ->where('orders.status = "new"')
                     ->where('orders.business = ?', $_SESSION['business']);
        list($this->view->unconfirmedOrders) = $db->fetchAll($select);


        // crm
        $select = $db->select()
                     ->from('crs', 'COUNT(*) as today')
                     ->where('crs.business = ' . $_SESSION['business'])
                     ->where('crs.date = "' . $today . '"');
        list($crmToday) = $db->fetchAll($select);
        $select = $db->select()
                     ->from('crs', 'COUNT(*) as active')
                     ->where('crs.business = ' . $_SESSION['business'])
                     ->where('crs.status = "active"');
        list($crmActive) = $db->fetchAll($select);
        $this->view->crm = array_merge($crmToday, $crmActive);


        // overdue invoices
        $select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'due', 'customer'))
                     ->joinLeft('customers', 'customers.customer_id = invoices.customer', 'name')
                     ->where('invoices.status = "unpaid"')
                     ->where('invoices.type = "invoice"')
                     ->where('invoices.due < ?', $today)
                     ->where('invoices.business = ?', $_SESSION['business']);
        $this->view->overdueInvoices = $db->fetchAll($select);



        // order link
        $select = $dDb->select()
                      ->from('companies', 'company_secret')
                      ->where('company_id = ?', $user->company);
        list($result) = $dDb->fetchAll($select);
        $this->view->companySecret = $result['company_secret'];

        $select = $db->select()
                      ->from('businesses', 'business_secret')
                      ->where('business_id = ?', $_SESSION['business']);
        list($result) = $db->fetchAll($select);
        $this->view->businessSecret = $result['business_secret'];
    }
}

