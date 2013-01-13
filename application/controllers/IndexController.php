<?php

class IndexController extends Zend_Controller_Action
{
    public function init()
    {
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;
        
        $this->view->isAdmin = $acl->access($role, $controller, $action);
    }
    
    public function indexAction()
    {

    }
}

