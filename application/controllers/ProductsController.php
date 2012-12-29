<?php

class ProductsController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('products', array('product_id', 'product', 'unit', 'status'))
                     ->joinLeft('businesses', 'products.business = businesses.business_id', array('business', 'business_id'))
                     ->joinLeft('prices', 'products.price = prices.price_id', 'price');

        // if "all"
        $business = $this->_request->getParam('business');
        if($business == 'all') {
            $this->view->showAll = true;
        } else {
            $business = (int)$business;
            $select->where('products.business = ' . $business);
        }

        // fetch data
        $products = $db->fetchAll($select);
        $this->view->products = $products;

        // empty so redirect
        if(!count($products)) {
            $this->_redirect('/products/all');
        }

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'product', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}