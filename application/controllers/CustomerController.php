<?php

class CustomerController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($customerId) = $parameters->get();

        // customer
        $select = $db->select()
                     ->from('customers', '*')
                     ->where('customer_id = ' . $customerId);

        $customer = $db->fetchAll($select);
        $this->view->customer = $customer[0];
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
        // status = deleted
    }
}