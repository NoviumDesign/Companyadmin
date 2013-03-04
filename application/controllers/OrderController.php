<?php

class OrderController extends Zend_Controller_Action
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
    
    public function addAction()
    {
        $db = Zend_Registry::get('db');

        $form = new Form_AddOrderForm();
        $this->view->form = $form;

        if($form->isValid() === true) {

            $secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);

            // insert
            $table = new Model_Db_Orders(array('db' => $db));
            $orderId = $table->insert(array(
                    'order_number' => $form->getValue('orderNumber'),
                    'order_secret' => $secret,
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

            if($form->getValue('deliveryStatus') == 'new' || $form->getValue('deliveryStatus') == 'active') {
                $status = 'active';
            } else {
                $status = 'completed';
            }

            $this->_redirect('/orders/view/' . $status);
        }
    }

    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($orderId) = $parameters->get();
        $this->view->orderId = $orderId;

        $form = new Form_EditOrderForm($orderId);
        $this->view->form = $form;

        if($form->isValid() === true  && $this->view->isAdmin) {

            // update order
            $table = new Model_Db_Orders(array('db' => $db));
            $table->update(array(
                    'order_number' => $form->getValue('orderNumber'),
                    'delivery_adress' => $form->getValue('deliveryAdress'),
                    'delivery' => $form->getValue('delivery'),
                    'delivery_date' => strtotime($form->getValue('deliveryDate') . ' ' . $form->getValue('deliveryTime')),
                    'status' => $form->getValue('deliveryStatus'),
                    'customer' => $form->getValue('customerId'),
                    'notes' => $form->getValue('orderNotes'),
                    'custom_1' => $form->getValue('custom1'),
                    'custom_2' => $form->getValue('custom2'),
                    'custom_3' => $form->getValue('custom3')
                    ),
                    'order_id = ' . $orderId . ' AND  business = ' . $_SESSION['business']
                );

            // update items
            foreach($_POST['item'] as $productId => $quantity) {

                // item exist
                $select = $db->select()
                             ->from('items', 'item_id')
                             ->where('items.product = ' . $productId . ' AND items.order = ' . $orderId);
                $result= $db->fetchAll($select);

                if($result) {
                    $itemExist = ($result[0]['item_id'] ? true : false);
                } else {
                    $itemExist = false;
                }

                if($quantity > 0) {
                    if($itemExist) {

                        // update
                        $table = new Model_Db_Items(array('db' => $db));
                        $table->update(array(
                            'quantity' => $quantity
                            ), 'items.order = ' . $orderId . ' AND items.product = ' . $productId);
                    } else {

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
                } else {
                    if($itemExist) {
                        // delete
                        $table = new Model_Db_Items(array('db' => $db));
                        $table->delete('items.order = ' . $orderId . ' AND items.product = ' . $productId);
                    }
                }
            }

            if($form->getValue('deliveryStatus') == 'new' || $form->getValue('deliveryStatus') == 'active') {
                $status = 'active';
            } else {
                $status = 'completed';
            }

            $this->_redirect('/orders/view/' . $status);
        }
    }

    public function deleteAction()
    {
        $parameters = new Emilk_Request_Parameters();
        list($orderId) = $parameters->get();

        $db = Zend_Registry::get('db');

        $table = new Model_Db_Orders(array('db' => $db));
        $result = $table->delete('orders.order_id = ' . $orderId . ' AND orders.business = ' . $_SESSION['business']);

        if($result) {
            $table = new Model_Db_Items(array('db' => $db));
            $table->delete('items.order = ' . $orderId);
        }

        $this->_redirect('/orders/view/');
    }
}