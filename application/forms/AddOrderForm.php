<?php

class Form_AddOrderForm extends Emilk_Form
{
	public $products = null;
	public $customFields = null;

	public function build()
	{
      $dDb = Zend_Db_Table::getDefaultAdapter();
        $db = Zend_Registry::get('db');
		$business = $_SESSION['business'];

    $select = $dDb->select()
                      ->from('users', array('id', 'name'))
                      ->where('company = ?', Zend_Auth::getInstance()->getStorage()->read()->company)
                      ->where('role <> ?', 'god')
                      ->order('users.name DESC');
        $carriers = $dDb->fetchAll($select);

		// products data
        $select = $db->select()
                     ->from('products', array('product_id', 'product'))
                     ->joinLeft('prices', 'prices.price_id = products.price', array('price', 'unit'))
                     ->where('products.business = ' . $business . ' AND products.status <> "deleted"')
                     ->order('product ASC');
        $result = $db->fetchAll($select);
        $this->products = $result;

        // custom fields
        $select = $db->select()
                     ->from('businesses', array('custom_field_1', 'custom_field_2', 'custom_field_3'))
                     ->where('business_id = ' . $business);
        $result = $db->fetchAll($select);
        $this->customFields =  $result[0];

        // order number
        $select = $db->select()
                     ->from('orders', '(COALESCE(MAX(order_number), 0) + 1) as orderNumber')
                     ->where('orders.business =' . $_SESSION['business']);
        $result= $db->fetchAll($select);
        $_orderNumber = $result[0]['orderNumber'];

		$orderNumber = new Emilk_Form_Element_Text('orderNumber');
		$orderNumber->setAttr('class', 'autocomplete')
				   ->setAttr('required', '')
				   ->setAttr('data-errortext', 'You can\'t add a new order without a order number')
				   ->setValue($_orderNumber);


		$customerId = new Emilk_Form_Element_Hidden('customerId');
		

		// products
		$products = array();
		foreach($this->products as $product) {

			$products[$product['product_id']] = new Emilk_Form_Element_Number('item[' . $product['product_id'] . ']');
			$products[$product['product_id']]->setAttr('class', 'decimal')
						 					 ->setAttr('data-min', '0');

		}


		$delivery = new Emilk_Form_Element_Radio('delivery');
		$delivery->setAttr('required', '')
				 ->addChoises(array(
					'approved',
					'requested',
					'none',
					'completed'
				 ));


		$deliveryDate = new Emilk_Form_Element_Text('deliveryDate');
		$deliveryDate->setAttr('class', 'date')
					 ->setAttr('data-value', '+7');


		$deliveryTime = new Emilk_Form_Element_Text('deliveryTime');
		$deliveryTime->setAttr('class', 'time')
					 ->setAttr('data-value', 'now');


		$deliveryAdress = new Emilk_Form_Element_Text('deliveryAdress');



    $carrier = new Emilk_Form_Element_Select('carrier');
    $carrier->addOption('')
            ->addOptions($carriers);


		$orderNotes = new Emilk_Form_Element_Textarea('orderNotes');
		$orderNotes->setAttr('data-autogrow', 'true');


		$deliveryStatus = new Emilk_Form_Element_Radio('deliveryStatus');
		$deliveryStatus->setAttr('required', '')
					   ->addChoises(array(
					   		'new',
					      'active',
					      'completed'
					   ));


		$addOrder = new Emilk_Form_Element_Button('addOrder');
		$addOrder->setAttr('class', 'submit green')
				 ->setValue('submit')
				 ->setText('Add order');


		$custom1 = new Emilk_Form_Element_Text('custom1');
		$custom2 = new Emilk_Form_Element_Text('custom2');
		$custom3 = new Emilk_Form_Element_Text('custom3');




		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/order/add')
			 ->add(array(
			 	$orderNumber,
			 	$customerId,
			 	$delivery,
			 	$deliveryDate,
			 	$deliveryTime,
			 	$deliveryAdress,
			 	$orderNotes,
			 	$deliveryStatus,
			 	$addOrder,
        $carrier,
			 	$custom1,
			 	$custom2,
			 	$custom3,
			 ))
			 ->add($products);
	}
}