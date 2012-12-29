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

        //  link to add
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;

        if($acl->isAllowed($role, 'business', 'add')) {
            $this->view->isAdmin = true;
        }
    }
}