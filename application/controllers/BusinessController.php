<?php

class BusinessController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $db = Zend_Registry::get('db');
        $id = $this->_request->getParam('id');

        // business
        $select = $db->select()
                     ->from('businesses', '*')
                     ->where('business_id = ' . $id);

        $business = $db->fetchAll($select);
        $this->view->business = $business[0];
    }
}