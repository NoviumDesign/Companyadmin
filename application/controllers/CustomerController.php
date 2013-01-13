<?php

class CustomerController extends Zend_Controller_Action
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
    
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($customerId) = $parameters->get();
        $this->view->customerId = $customerId; 

        $form = new Form_EditCustomerForm($customerId);
        $this->view->form = $form;

        if($this->_request->isPost()) {
            if($form->isValid()) {

                $table = new Model_Db_Customers(array('db' => $db));
                $table->update(array(
                        'registered' => $form->getValue('registered'),
                        'name' => $form->getValue('customerName'),
                        'type' => $form->getValue('type'),
                        'mail' => $form->getValue('mail'),
                        'phone' => $form->getValue('phone'),
                        'customer_adress' => $form->getValue('adress'),
                        'box' => $form->getValue('box'),
                        'zip_code' => $form->getValue('zipCode'),
                        'city' => $form->getValue('city'),
                        'country' => $form->getValue('country'),
                        'notes' => $form->getValue('notes')
                    ), 'customers.customer_id = ' . $customerId . ' AND customers.business = ' . $_SESSION['business']);

                $this->_redirect('/customers/view');
            }
        }
    }

    public function addAction()
    {
        $db = Zend_Registry::get('db');

        $form = new Form_AddCustomerForm();
        $this->view->form = $form;

        if($this->_request->isPost()) {
            if($form->isValid()) {

                $table = new Model_Db_Customers(array('db' => $db));
                $table->insert(array(
                        'registered' => 'true',
                        'business' => $_SESSION['business'],
                        'name' => $form->getValue('customerName'),
                        'type' => $form->getValue('type'),
                        'mail' => $form->getValue('mail'),
                        'phone' => $form->getValue('phone'),
                        'customer_adress' => $form->getValue('adress'),
                        'box' => $form->getValue('box'),
                        'zip_code' => $form->getValue('zipCode'),
                        'city' => $form->getValue('city'),
                        'country' => $form->getValue('country'),
                        'notes' => $form->getValue('notes')
                    ));

                $this->_redirect('/customers/view');
            }
        }

    }

    public function deleteAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($customerId) = $parameters->get();

        $table = new Model_Db_Customers(array('db' => $db));
        $table->delete('customers.customer_id = ' . $customerId . ' AND customers.business = ' . $_SESSION['business']);

        $this->_redirect('/customers/view/');
    }
}