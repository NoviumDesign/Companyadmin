<?php

class ProductsController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        
        // select
        $select = $db->select()
                     ->from('products', array('product_id', 'product', 'price', 'unit', 'status'))
                     ->joinLeft('businesses', 'products.business = businesses.business_id', array('business', 'business_id'));

        // if "all"
        $business = $this->_request->getParam('business');
        if($business == 'all') {
            $this->view->showAll = true;
        } else {
            $business = (int)$business;
            $select->where('products.business = ' . $business);
        }

        // fetch data
        $result = $db->fetchAll($select);
        $this->view->products = $result;

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'product', 'add')) {
            $this->view->isAdmin = true;
            $result = $db->fetchAll($select);
            $this->view->customs = $result;
        }
    }
}