<?php

class Form_EditOrderForm extends Emilk_Form
{
	public $id = 0;
	public $products = null;
	public $order = null;
	public $customFields = null;

	function __construct($id) {
        parent::__construct();

        $this->id = $id;
    }

	public function build()
	{
        $db = Zend_Registry::get('db');
		$id = $this->id;
		$business = $_SESSION['business'];

		// order data
		$select = $db->select()
                     ->from('orders', array('order_id', 'delivery_adress', 'delivery', 'delivery_date', 'status', 'customer', 'notes', 'custom_1', 'custom_2', 'custom_3'))
                     ->joinLeft('customers', 'orders.customer = customers.customer_id', 'name')
                     ->where('orders.order_id = ' . $id . ' AND orders.business = ' . $business);
        $result = $db->fetchAll($select);
        $this->order = $result[0];

        if(!$this->order) {
			header('Location: /orders/view');
        }

        // products data
        $select = $db->select()
                     ->from('products', array('product_id', 'product',
                        '(SELECT price FROM prices WHERE products.price = prices.price_id) as momentary_price',
                        '(SELECT unit FROM prices WHERE products.price = prices.price_id) as momentary_unit'))
                     ->joinLeft('items', 'items.product = products.product_id AND items.order = '. $id, 'quantity')
                     ->joinLeft('prices', 'prices.price_id = items.price', array('price', 'unit'))
                     ->where('products.business = ' . $business)
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->products = $result;

        // custom fields
        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $business);
        $result = $db->fetchAll($select);
        $this->customFields =  $result[0];


        $order = $this->order;


		$customerId = new Emilk_Form_Element_Text('customerId');
		$customerId->setAttr('class', 'autocomplete')
				   // ->setAttr('data-source', '[abc,def,ghi,jkl,mno,pqr,stu,vwx,yz]')
				   ->setAttr('required', '')
				   ->setAttr('data-errortext', 'You can\'t add a new order without a customer')
				   ->setValue($order['customer']);


		// products
		$products = array();
		foreach($this->products as $product) {

			$products[$product['product_id']] = new Emilk_Form_Element_Number($product['product_id']);
			$products[$product['product_id']]->setAttr('class', 'decimal')
						 					 ->setAttr('data-min', '0')
					     					 ->setValue($product['quantity']);

		}


		$delivery = new Emilk_Form_Element_Radio('delivery');
		$delivery->setAttr('required', '')
				 ->addChoises(array(
					'approved',
					'requested',
					'none'))
				 ->setValue($order['delivery']);


		$deliveryDate = new Emilk_Form_Element_Text('deliveryDate');
		$deliveryDate->setAttr('class', 'date')
				     ->setValue(date('d/m/Y', $order['delivery_date']));	// GMT?


		$deliveryTime = new Emilk_Form_Element_Text('deliveryTime');
		$deliveryTime->setAttr('class', 'time')
				   	 ->setValue(date('H:i', $order['delivery_date']));		// GMT?


		$deliveryAdress = new Emilk_Form_Element_Text('deliveryAdress');
		$deliveryAdress->setValue($order['delivery_adress']);


		$orderNotes = new Emilk_Form_Element_Textarea('orderNotes');
		$orderNotes->setAttr('data-autogrow', 'true')
				   ->setValue($order['notes']);


		$deliveryStatus = new Emilk_Form_Element_Radio('deliveryStatus');
		$deliveryStatus->setAttr('required', '')
					   ->addChoises(array(
					      'active',
					      'completed'))
				   	   ->setValue($order['status']);


		$custom1 = new Emilk_Form_Element_Text('custom1');
		$custom1->setValue($order['custom_1']);
		$custom2 = new Emilk_Form_Element_Text('custom2');
		$custom2->setValue($order['custom_2']);
		$custom3 = new Emilk_Form_Element_Text('custom3');
		$custom3->setValue($order['custom_3']);


		$addOrder = new Emilk_Form_Element_Button('addOrder');
		$addOrder->setAttr('class', 'submit')
				 ->setValue('submit')
				 ->setText('Edit order');




		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/order/view/' . $id)
			 ->add(array(
			 	$customerId,
			 	$delivery,
			 	$deliveryDate,
			 	$deliveryTime,
			 	$deliveryAdress,
			 	$orderNotes,
			 	$deliveryStatus,
			 	$addOrder,
			 	$custom1,
			 	$custom2,
			 	$custom3,
			 ))
			 ->add($products);

	}
}