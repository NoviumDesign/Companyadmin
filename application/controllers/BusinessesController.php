<?php

class BusinessesController extends Zend_Controller_Action
{
    public function allAction()
    {
        $db = Zend_Registry::get('db');

        // customers
        $select = $db->select()
                     ->from('businesses', array('business_id', 'business', 'custom_field_1', 'custom_field_2', 'custom_field_3'));

        $businesses = $db->fetchAll($select);
        $this->view->businesses = $businesses;

        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }
}