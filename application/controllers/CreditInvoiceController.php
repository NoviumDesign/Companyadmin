<?php

class CreditInvoiceController extends Zend_Controller_Action
{
    public function init()
    {
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;
        $adminVal =  array_search('admin', $acl::$roles);
        $roleVal =  array_search($role, $acl::$roles);

        $this->view->isAdmin = false;
        if($roleVal >= $adminVal) {
            $this->view->isAdmin = true;
        }
    }

    public function addAction()
    {
        $db = Zend_Registry::get('db');

        // if create from order
        $parameters = new Emilk_Request_Parameters();
        list($orderId) = $parameters->get();

        $form = new Form_AddCreditInvoiceForm($orderId);
        $this->view->form = $form;

        if($form->isValid() === true) {

            $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);

            // invoice number
            $select = $db->select()
                         ->from('invoices', '(COALESCE(MAX(invoice_number), 0) + 1) AS invoiceNumber')
                         ->where('invoices.business =' . $_SESSION['business']);
            $result= $db->fetchAll($select);
            $_invoiceNumber = $result[0]['invoiceNumber'];
            
            // insert
            $table = new Model_Db_Invoices(array('db' => $db));
            $invoiceId = $table->insert(array(
                    'invoice_number' => $_invoiceNumber,
                    'invoice_secret' => $secret,
                    'business' => $_SESSION['business'],
                    'customer' => $form->getValue('customerId'),
                    'status' => $form->getValue('status'),
                    'date' => time(),
                    'discount' => $form->getValue('discount'),
                    'notes' => $form->getValue('notes'),
                    'type' => 'credit-invoice'
                ));

            // create items
            foreach($_POST['item'] as $productId => $quantity) {
                if($quantity > 0) {

                    // get price
                    $price = $_POST['price'][$productId];

                    // insert
                    $table = new Model_Db_Items(array('db' => $db));
                    $table->insert(array(
                            'product' => $productId,
                            'invoice' => $invoiceId,
                            'quantity' => $quantity,
                            'price' => $price
                        ));
                }
            }

            // from order?
            if($form->getValue('orderId')) {
                $table = new Model_Db_Orders(array('db' => $db));
                $table->update(array(
                        'status' => 'invoice'
                    ),
                    'order_id = ' . $form->getValue('orderId') . ' AND  business = ' . $_SESSION['business']
                );
            }

            $this->_redirect('/credit-invoice/view/' . $invoiceId);
        }
    }

    public function editAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();

        if(!$invoiceId) {
            $this->_redirect('/credit-invoices/view');
        }

        $form = new Form_EditCreditInvoiceForm($invoiceId);
        $this->view->form = $form;

        if($form->isValid() === true) {

            // update order
            $table = new Model_Db_Invoices(array('db' => $db));
            $table->update(array(
                    'invoice_number' => $form->getValue('invoiceNumber'),
                    'customer' => $form->getValue('customerId'),
                    'status' => $form->getValue('status'),
                    'date' => strtotime($form->getValue('invoiceDate')),
                    'discount' => $form->getValue('discount'),
                    'notes' => $form->getValue('notes')
                    ),
                    'invoices.invoice_id = ' . $invoiceId . ' AND  invoices.business = ' . $_SESSION['business']
                );

            // update items
            foreach($_POST['item'] as $productId => $quantity) {

                // item exist
                $select = $db->select()
                             ->from('items', 'item_id')
                             ->where('items.product = ' . $productId . ' AND items.invoice = ' . $invoiceId);
                $result= $db->fetchAll($select);

                if($result) {
                    $itemExist = ($result[0]['item_id'] ? true : false);
                } else {
                    $itemExist = false;
                }

                if($quantity > 0) {
                    if($itemExist) {

                        // update
                        $table = new Model_Db_Items(array('db' => $db));
                        $table->update(array(
                            'quantity' => $quantity
                            ), 'items.invoice = ' . $invoiceId . ' AND items.product = ' . $productId);
                    } else {

                        // get price
                        $select = $db->select()
                                     ->from('products', 'price')
                                     ->where('product_id = ' . $productId);
                        $result= $db->fetchAll($select);
                        $price = $result[0]['price'];

                        // insert
                        $table = new Model_Db_Items(array('db' => $db));
                        $table->insert(array(
                                'product' => $productId,
                                'invoice' => $invoiceId,
                                'quantity' => $quantity,
                                'price' => $price
                            ));
                    }
                } else {
                    if($itemExist) {
                        // delete
                        $table = new Model_Db_Items(array('db' => $db));
                        $table->delete('items.invoice = ' . $invoiceId . ' AND items.product = ' . $productId);
                    }
                }
            }
            $this->_redirect('/credit-invoice/view/' . $invoiceId);
        }
        
    }

    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();

        if(!$invoiceId) {
            $this->_redirect('/credit-invoices/view');
        }

        $this->view->invoiceId = $invoiceId;

        // invoice
        $select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'status', 'discount', 'notes', 'invoice_secret'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name as customer_name', 'customer_id', 'customer_adress', 'zip_code', 'city', 'country', 'mail', 'type', 'reference'))
                     ->where('invoices.type = "credit-invoice"')
                     ->where('invoices.invoice_id = ' . $invoiceId . ' AND invoices.business = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);
        $this->view->invoice = $result[0];

        if (!count($result)) {
            $this->_redirect('/credit-invoices/view');
        }

        // items
        $select = $db->select()
                     ->from('items', 'quantity')
                     ->joinLeft('products','items.product = products.product_id', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit', 'vat'))
                     ->where('items.invoice = ' . $invoiceId . ' AND products.business = ' . $_SESSION['business'])
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->view->items = $result;

        // business company
        $select = $db->select()
                     ->from('businesses', array('company_name', 'company_adress', 'company_zip_code', 'company_city', 'company_country', 'business_secret', 'invoice_prefix', 'invoice_mail_title', 'invoice_mail_content', 'invoice_detail', 'company_reference'))
                     ->where('businesses.business_id = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);
        $this->view->businessComapny = $result[0];

        // pdf link
        $dDb = Zend_Db_Table::getDefaultAdapter();
        $companyId = Zend_Auth::getInstance()->getStorage()->read()->company;

        $select = $dDb->select()
                      ->from('companies', 'company_secret')
                      ->where('companies.company_id = ' . $companyId);
        $result = $dDb->fetchAll($select);
        $this->view->pdfLink = $result[0]['company_secret'] . '/' . $this->view->businessComapny['business_secret'] . '/' . $this->view->invoice['invoice_secret'];

        // mailto
        $mailAdress = $this->view->invoice['mail'];
        $invoiceLink = 'http://companyadmins.elasticbeanstalk.com/' . $this->view->pdfLink;
        $mail = 'mailto:' . $mailAdress . '?subject=Kreditfaktura&body=' . $invoiceLink;

        $this->view->mailTo = $mail;
    }

    public function deleteAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();

        $table = new Model_Db_Invoices(array('db' => $db));
        $result = $table->delete('invoices.invoice_id = ' . $invoiceId . ' AND invoices.type = "credit-invoice" AND invoices.business = ' . $_SESSION['business']);

        if($result) {
            $table = new Model_Db_Items(array('db' => $db));
            $table->delete('items.invoice = ' . $invoiceId);
        }

        $this->_redirect('/credit-invoices/view/');
    }
}