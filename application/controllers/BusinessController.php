<?php

class BusinessController extends Zend_Controller_Action
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