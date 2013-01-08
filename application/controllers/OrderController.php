<?php

class OrderController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $id = $this->_request->getParam('id');
        $db = Zend_Registry::get('db');

        $form = new Form_EditOrderForm($id);
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
                    ), 'order_id = ' . $id . ' AND  business = ' . $_SESSION['business']);

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
            $table = new Model_Db_Orders(array('db' => $db));
            $orderId = $table->insert(array(
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

            // create items
            foreach($_POST['item'] as $productId => $quantity) {
                if($quantity > 0) {

                    // get price
                    $select = $db->select()
                                 ->from('products', 'price')
                                 ->where('product_id = ' . $productId);
                    $result= $db->fetchAll($select);
                    $price = $result[0]['price'];

                    // insert
                    $table = new Model_Db_Items(array('db' => $db));
                    $table->insert(array(
                            'product' => $productId,
                            'order' => $orderId,
                            'quantity' => $quantity,
                            'price' => $price
                        ));
                }
            }
            $this->_redirect('/orders/view/');
        }
    }
}