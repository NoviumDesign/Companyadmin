<?php

class ProductController extends Zend_Controller_Action
{  
    public function addAction()
    {
        $db = Zend_Registry::get('db');

        $form = new Form_AddProductForm();
        $this->view->form = $form;

        $request = $this->getRequest();
        if($request->isPost()) {
            if($form->isValid()) {

                $table = new Model_Db_Prices(array('db' => $db));
                $priceId = $table->insert(array(
                        'price' => $form->getValue('price'),
                        'unit' => $form->getValue('unit'),
                        'date' => time()
                    ));

                $table = new Model_Db_Products(array('db' => $db));
                $table->insert(array(
                        'product_number' => $form->getValue('productNumber'),
                        'business' => $_SESSION['business'],
                        'product' => $form->getValue('productName'),
                        'price' => $priceId,
                        'status' => $form->getValue('status'),
                        'description' => $form->getValue('description'),
                        'notes' => $form->getValue('notes'),
                        'date' => time()
                    ));

                $this->_redirect('/products/view');
            }
        }
    }

    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($productId) = $parameters->get();
        $this->view->productId = $productId;

        $form  = new Form_EditProductForm($productId);
        $this->view->form = $form;

        $request = $this->getRequest();
        if($request->isPost()) {
            if($form->isValid()) {

                $table = new Model_Db_Prices(array('db' => $db));
                $priceId = $table->insert(array(
                        'price' => $form->getValue('price'),
                        'unit' => $form->getValue('unit'),
                        'date' => time()
                    ), '');

                $table = new Model_Db_Products(array('db' => $db));
                $table->update(array(
                        'product_number' => $form->getValue('productNumber'),
                        'product' => $form->getValue('productName'),
                        'price' => $priceId,
                        'status' => $form->getValue('status'),
                        'description' => $form->getValue('description'),
                        'notes' => $form->getValue('notes')
                    ), 'products.product_id = ' . $productId);

                $this->_redirect('/products/view');
            }
        }
    }

    public function deleteAction()
    {      
        $db = Zend_Registry::get('db'); 

        $parameters = new Emilk_Request_Parameters();
        list($productId) = $parameters->get();

        $table = new Model_Db_Products(array('db' => $db));
        $table->update(array(
                'status' => 'deleted'
            ), 'products.product_id = ' . $productId . ' AND products.business = ' . $_SESSION['business']);

        $this->_redirect('/products/view');
    }
}