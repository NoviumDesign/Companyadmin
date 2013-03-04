<?php

class Form_EditCrForm extends Emilk_Form
{
	public $crId;

	function __construct($crId)
	{
        parent::__construct();
        
		$this->crId = $crId;
	}

	public function build()
	{
    	$db = Zend_Registry::get('db');

		// form data
        $select = $db->select()
                     ->from('crs', array('status', 'date', 'task'))
                     ->joinLeft('customers', 'customers.customer_id = crs.customer', array('customer_id', 'name'))
                     ->where('crs.crs_id = ' . $this->crId);
        $result = $db->fetchAll($select);
        $cr = $result[0];

        if(!$cr) {
			header('Location: /crs/view/active');
        }

		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			   ->addChoises(array(
			  	'active',
			  	'completed'
			   ))
			   ->setValue($cr['status']);

		$customerId = new Emilk_Form_Element_Hidden('customerId');
		$customerId->setValue($cr['customer_id']);

		$customer = new Emilk_Form_Element_Text('customer');
		$customer->setAttr('required', '')
				 ->setValue($cr['name']);

		$date = new Emilk_Form_Element_Text('date');
		$date->setAttr('class', 'date')
			 ->setValue(date('Y-m-d', $cr['date']));

		$task = new Emilk_Form_Element_Textarea('task');
		$task->setAttr('data-autogrow', 'true')
			 ->setValue($cr['task']);

		$submit = new Emilk_Form_Element_Button('submit');
		$submit->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Edit task');

		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->add(array(
			 	$status,
			 	$customerId,
			 	$customer,
			 	$date,
			 	$task,
			 	$submit
			 ));
	}
}