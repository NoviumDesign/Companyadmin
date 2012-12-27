<?php

class OrderController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function addAction()
    {
		$db = Zend_Registry::get('db');
		$form = new Form_AddOrderForm();

		$request = $this->getRequest();
        if($request->isPost()) {
            if($form->isValid($this->_request->getPost())) {

            	$db->insert('orders', array(
            		'date' => Zend_Date::now()->getTimestamp() + 3600, // temp fix
            		'type' => $form->getValue('type'),
            		'items' => $form->getValue('items'),
            		'location' => $form->getValue('location'),
            		'delivery' => $form->getValue('delivery'),
            		'delivery_date' => $form->getValue('deliveryDate'),
            		'completed' => $form->getValue('completed'),
            		'by' => $form->getValue('by'),
            	));

            	$this->_redirect('orders/list');
            }
        }

		$this->view->form = $form;

        
    }
}