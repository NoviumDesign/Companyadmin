<?php

class ProductsController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('products', array('product_id', 'product_number', 'product', 'status'))
                     ->joinLeft('prices', 'products.price = prices.price_id', array('price', 'unit', 'vat'))
                     ->where('products.business = ' . $_SESSION['business'] . ' AND products.status <> "deleted"');
        $products = $db->fetchAll($select);

        $this->view->products = $products;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}