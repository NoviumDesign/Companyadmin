<?php

class OrderController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $id = $this->_request->getParam('id');
        $db = Zend_Registry::get('db');

        // receiving data for form
        $select = $db->select()
                     ->from('orders', array('order_id', 'delivery_adress', 'delivery', 'delivery_date', 'status', 'customer', 'notes', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', 'name')
                     ->where('orders.order_id = ' . $id . ' AND orders.business = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);
        $order = $result[0];

        $form = new Form_EditOrderForm(array($order, $this->getProducts(), $this->getCustomFields()));
        $this->view->form = $form;

        if($form->isValid() === true) {
            // update
            Zend_Db_Table::setDefaultAdapter($db);
            $orders = new Zend_Db_Table('orders');
            $orders->update(array(
                        'delivery_adress' => $form->getValue('deliveryAdress'),
                        'delivery' => $form->getValue('delivery'),
                        'delivery_date' => strtotime($form->getValue('deliveryDate') . ' ' . $form->getValue('deliveryTime')),
                        'status' => $form->getValue('deliveryStatus'),
                        'customer' => $form->getValue('customerId'),
                        'notes' => $form->getValue('orderNotes'),
                        'custom_1' => $form->getValue('custom1'),
                        'custom_2' => $form->getValue('custom2'),
                        'custom_3' => $form->getValue('custom3')
                    ), 'order_id = ' . $id . ' AND  business' . $_SESSION['business']);

            $this->_redirect('/orders/view');
        }
    } 

    public function addAction()
    {
        $db = Zend_Registry::get('db');

        $form = new Form_AddOrderForm();
        $this->view->form = $form;

        if($form->isValid() === true) {
            // order number
            $select = $db->select()
                         ->from('orders', 'COUNT(order_id) + 1 as orderNumber')
                         ->where('orders.business =' . $_SESSION['business']);
            $result= $db->fetchAll($select);
            $orderNumber = $result[0]['orderNumber'];

            // insert
            $db->insert('orders', array(
                    'order_number' => $orderNumber,
                    'date' => time(),
                    'business' => $_SESSION['business'],
                    'delivery_adress' => $form->getValue('deliveryAdress'),
                    'delivery' => $form->getValue('delivery'),
                    'delivery_date' => strtotime($form->getValue('deliveryDate') . ' ' . $form->getValue('deliveryTime')),
                    'status' => $form->getValue('deliveryStatus'),
                    'customer' => $form->getValue('customerId'),
                    'notes' => $form->getValue('orderNotes'),
                    'custom_1' => $form->getValue('custom1'),
                    'custom_2' => $form->getValue('custom2'),
                    'custom_3' => $form->getValue('custom3')
                ));

            $this->_redirect('/orders/view');
        }
    }

    public function getProducts()
    {
        $db = Zend_Registry::get('db');
        $id = $this->_request->getParam('id');

        $select = $db->select()
                     ->from('products', array('product_id', 'product',
                        '(SELECT price FROM prices WHERE products.price = prices.price_id) as momentary_price',
                        '(SELECT unit FROM prices WHERE products.price = prices.price_id) as momentary_unit'))
                     ->joinLeft('items', 'items.product = products.product_id AND items.order = '. $id, 'quantity')
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit'))
                     ->where('products.business = ' . $_SESSION['business'])
                     ->order('product ASC');
        $result = $db->fetchAll($select);

        return $result;
    }

    public function getCustomFields() {
        $db = Zend_Registry::get('db');
        $id = $this->_request->getParam('id');

        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);

        return $result[0];
    }
}