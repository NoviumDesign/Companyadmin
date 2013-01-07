<?php

class ProductsController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('products', array('product_id', 'product_number', 'product', 'unit', 'status'))
                     ->joinLeft('prices', 'products.price = prices.price_id', 'price')
                     ->where('products.business = ' . $_SESSION['business']);
        $products = $db->fetchAll($select);

        $this->view->products = $products;

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'product', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}