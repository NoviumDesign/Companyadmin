<?php

class Form_AddOrderForm extends Zend_Form
{
	public function __construct($option = null) {
		parent::__construct($option);
		$db = Zend_Registry::get('db');

		// type
		$select = $db->select()
					 ->from('types', '*');

		$result = $db->fetchAll($select);

		$options = array();
		foreach($result as $i) {
			$options[$i['type_id'] . 'key'] = $i['type'];
		}

		$type = new Zend_Form_Element_Select('type');
		$type->setLabel('Type: ')
			 ->addMultiOptions($options);


		// items
		$items = new Zend_Form_Element_Text('items');
		$items->setLabel('items: ')
			  ->setRequired();

		// location
		$location = new Zend_Form_Element_Text('location');
		$location->setLabel('location: ')
				 ->setRequired();

		// delivery
		$delivery = new Zend_Form_Element_Select('delivery');
		$delivery->setLabel('delivery: ')
				 ->addMultiOptions(array(
				 	'requested' => 'requested',
				 	'approved' => 'approved'
				 ));

		// deliveryDate
		$deliveryDate = new Zend_Form_Element_Text('deliveryDate');
		$deliveryDate->setLabel('delivery date')
					 ->addValidator('Digits')
					 ->setRequired();

		// completed
		$completed = new Zend_Form_Element_Select('completed');
		$completed->setLabel('completed: ')
				  ->addMultiOptions(array(
				 	 'yes' => 'yes',
				 	 'no' => 'no',
				 	 'active' => 'active'
				  ));

		// by
		$by = new Zend_Form_Element_Text('by');
		$by->setLabel('by: ')
		   ->setRequired();

		// create
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('submit');


		$this->setName('addOrder')
			 ->setMethod('post')
			 ->setAction('/order/add')
			 ->addElements(array($type, $items, $location, $delivery, $deliveryDate, $completed, $by, $submit));
	}
}