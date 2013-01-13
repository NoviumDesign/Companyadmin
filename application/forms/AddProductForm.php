<?php

class Form_AddProductForm extends Emilk_Form
{
	public function build()
	{
		$business = $_SESSION['business'];


		$productNumber = new Emilk_Form_Element_Text('productNumber');
		$productNumber->setAttr('required', '')
				      ->setAttr('data-errortext', 'You can\'t add a new product without a product number');


		$productName = new Emilk_Form_Element_Text('productName');
		$productName->setAttr('required', '')
				    ->setAttr('data-errortext', 'You can\'t add a new product without a product name');


		$price = new Emilk_Form_Element_Number('price');
		$price->setAttr('required', '')
			  ->setAttr('data-errortext', 'You can\'t add a new product without a price')
		      ->setAttr('class', 'decimal')
			  ->setAttr('data-min', '0');


		$unit = new Emilk_Form_Element_Text('unit');
		$unit->setAttr('required', '')
			 ->setAttr('data-errortext', 'You can\'t add a new product without a unit');


		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			   ->addChoises(array(
				  'available',
				  'out of stock'
			   ));


		$description = new Emilk_Form_Element_Textarea('description');


		$notes = new Emilk_Form_Element_Textarea('notes');


		$addProduct = new Emilk_Form_Element_Button('addProduct');
		$addProduct->setAttr('class', 'submit green')
				   ->setValue('submit')
				   ->setText('Add product');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/product/add')
			 ->add(array(
			 	$productNumber,
			 	$productName,
			 	$price,
			 	$unit,
			 	$status,
			 	$description,
			 	$notes,
			 	$addProduct
			 ));
	}
}