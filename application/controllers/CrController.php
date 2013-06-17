<?php

class CrController extends Zend_Controller_Action
{
    public function addAction()
    {
    	$db = Zend_Registry::get('db');

        $form = new Form_AddCrForm();
        $this->view->form = $form;

        if($form->isValid() === true) {

            $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);
            
            // insert
            $table = new Model_Db_Crs(array('db' => $db));
            $table->insert(array(
                'crs_secret' => $secret,
                'customer' => $form->getValue('customerId'),
                'status' => $form->getValue('status'),
                'date' => strtotime($form->getValue('date')),
                'task' => $form->getValue('task'),
                'business' => $_SESSION['business']
            ));

            $this->_redirect('/crs/view/' . $form->getValue('status'));
        }
    }

    public function viewAction()
    {
    	$db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($crId) = $parameters->get();

        if(!$crId) {
            $this->_redirect('/crs/view');
        }

        $this->view->crId = $crId;

        $form = new Form_EditCrForm($crId);
        $this->view->form = $form;

        if($form->isValid() === true) {

        	$table = new Model_Db_Crs(array('db' => $db));
            $table->update(array(
	                'customer' => $form->getValue('customerId'),
	                'status' => $form->getValue('status'),
	                'date' => strtotime($form->getValue('date')),
	                'task' => $form->getValue('task')
            	),
            	'crs_id = ' . $crId . ' AND business = ' . $_SESSION['business']
            );

            $this->_redirect('/crs/view/' . $form->getValue('status'));
        }
        
        // is admin
        $acl = new Model_LibraryAcl;
        $this->view->isAdmin = $acl->access(Zend_Auth::getInstance()->getStorage()->read()->role, 'order', 'add');
    }

    public function deleteAction()
    {
    	$db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($crId) = $parameters->get();

        $table = new Model_Db_Crs(array('db' => $db));
        $table->delete(
        	'crs_id = ' . $crId . ' AND business = ' . $_SESSION['business']
        );

        $this->_redirect('/crs/view/active');
    }
}