<?php

class OrderController extends Zend_Controller_Action
{
  public function indexAction()
  {
      $db = Zend_Registry::get('db');
      $id = $this->_request->getParam('id');

      // order
      $select = $db->select()
                   ->from('orders', '*')
                   ->joinLeft('businesses', 'orders.business = businesses.business_id', array('business_id', 'business'))
                   ->joinLeft('customers', 'orders.customer = customers.customer_id', '*')
                   ->where('orders.order_id =' . $id);

      $order = $db->fetchAll($select);
      $this->view->order = $order[0];

      // custom fields
      $business_id = $order[0]['business_id'];
      $select = $db->select()
                   ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                   ->where('businesses.business_id =' . $business_id);

      $custom_fields = $db->fetchAll($select);
      $this->view->custom_fields = $custom_fields[0];

      // items
      $select = $db->select()
                   ->from('items', 'quantity')
                   ->joinLeft('products', 'items.product = products.product_id', array('product_id', 'product', 'unit'))
                   ->joinLeft('prices', 'items.price = prices.price_id', 'price')
                   ->where('items.order =' . $id);

      $items = $db->fetchAll($select);
      $this->view->items = $items;


  }

  public function addAction()
  {
	  $db = Zend_Registry::get('db');

	  $form = new Form_AddOrderForm();
    $this->view->form = $form;

    if($form->isValid() == true) {
      echo 'klart!';
    }
  }
  
}