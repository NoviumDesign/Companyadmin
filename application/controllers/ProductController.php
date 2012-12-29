<?php

class ProductController extends Zend_Controller_Action
{  
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        $id = $this->_request->getParam('id');

        // product
        $select = $db->select()
                     ->from('products', '*')
                     ->joinLeft('businesses', 'products.business = businesses.business_id', 'business')
                     ->joinLeft('prices', 'products.price = prices.price_id', array('price', 'prices.date as price_date'))
                     ->where('products.product_id =' . $id);

        $product = $db->fetchAll($select);
        $this->view->product = $product[0];
    }
}