<?php

class InvoiceController extends Zend_Controller_Action
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

        $form = new Form_AddInvoiceForm($orderId);
        $this->view->form = $form;

        if($form->isValid() === true) {

            // insert
            $table = new Model_Db_Invoices(array('db' => $db));
            $invoiceId = $table->insert(array(
                    'invoice_number' => $form->getValue('invoiceNumber'),
                    'business' => $_SESSION['business'],
                    'customer' => $form->getValue('customer'),
                    'status' => $form->getValue('status'),
                    'date' => time(),
                    'due' => strtotime($form->getValue('invoiceDue')),
                    'discount' => $form->getValue('discount'),
                    'notes' => $form->getValue('notes')
                ));

            // create items
            foreach($_POST['item'] as $productId => $quantity) {
                if($quantity > 0) {

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
            }
            $this->_redirect('/invoice/view/' . $invoiceId);
        }
    }

    public function editAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();

        $form = new Form_EditInvoiceForm($invoiceId);
        $this->view->form = $form;

        if($form->isValid() === true) {

            // update order
            $table = new Model_Db_Invoices(array('db' => $db));
            $table->update(array(
                    'invoice_number' => $form->getValue('invoiceNumber'),
                    'customer' => $form->getValue('customer'),
                    'status' => $form->getValue('status'),
                    'due' => strtotime($form->getValue('invoiceDue')),
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
            $this->_redirect('/invoice/view/' . $invoiceId);
        }
        
    }

    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();
        $this->view->invoiceId = $invoiceId;

        // invoice
        $select = $db->select()
                     ->from('invoices', array('invoice_id', 'invoice_number', 'date', 'due', 'status', 'discount', 'notes'))
                     ->joinLeft('customers', 'invoices.customer = customers.customer_id', array('name as customer_name', 'customer_id', 'customer_adress', 'zip_code', 'city', 'country'))
                     ->where('invoices.invoice_id = ' . $invoiceId . ' AND invoices.business = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);
        $this->view->invoice = $result[0];

        // items
        $select = $db->select()
                     ->from('items', 'quantity')
                     ->joinLeft('products','items.product = products.product_id', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit'))
                     ->where('items.invoice = ' . $invoiceId . ' AND products.business = ' . $_SESSION['business'])
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->view->items = $result;

        // business company
        $select = $db->select()
                     ->from('businesses', array('company_name', 'company_adress', 'company_zip_code', 'company_city', 'company_country'))
                     ->where('businesses.business_id = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);

        $this->view->businessComapny = $result[0];
    }

    public function deleteAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($invoiceId) = $parameters->get();

        $table = new Model_Db_Invoices(array('db' => $db));
        $result = $table->delete('invoices.invoice_id = ' . $invoiceId . ' AND invoices.business = ' . $_SESSION['business']);

        if($result) {
            $table = new Model_Db_Items(array('db' => $db));
            $table->delete('items.invoice = ' . $invoiceId);
        }

        $this->_redirect('/invoices/view/');
    }
}