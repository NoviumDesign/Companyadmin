<?php

class Form_EditOrderForm extends Emilk_Form
{
	public $array = array();

	function __construct($array) {
        parent::__construct();

        $this->array = $array;
    }

	public function build()
	{
        $order = $this->array[0];


		$customerId = new Emilk_Form_Element_Text('customerId');
		$customerId->setAttr('class', 'autocomplete')
				   // ->setAttr('data-source', '[abc,def,ghi,jkl,mno,pqr,stu,vwx,yz]')
				   ->setAttr('required', '')
				   ->setAttr('data-errortext', 'You can\'t add a new order without a customer')
				   ->setValue($order['customer']);


		// products
		$products = array();
		foreach($this->array[1] as $product) {

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
					 ->setAttr('data-value', '+7')
				     ->setValue(date('d/m/Y', $order['delivery_date']));	// GMT?


		$deliveryTime = new Emilk_Form_Element_Text('deliveryTime');
		$deliveryTime->setAttr('class', 'time')
					 ->setAttr('data-value', 'now')
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
			 ->setAttr('action', '/order/' . $order['order_id'])
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