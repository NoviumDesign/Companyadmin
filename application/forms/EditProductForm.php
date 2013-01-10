<?php

class Form_EditProductForm extends Emilk_Form
{	
	public $productId;

	function __construct($productId)
	{
        parent::__construct();
        
		$this->productId = $productId;
	}

	public function build()
	{
        $db = Zend_Registry::get('db');

		// get product data
		$select = $db->select()
                     ->from('products', array('product_number', 'product', 'status', 'description', 'notes'))
                     ->joinLeft('prices', 'products.price = prices.price_id', array('price', 'unit'))
                     ->where('products.product_id = ' . $this->productId . ' AND products.business = ' . $_SESSION['business']);
        $result = $db->fetchAll($select);

        if(!$result) {
			header('Location: /products/view');
   		}

        $product = $result[0];


		$productNumber = new Emilk_Form_Element_Text('productNumber');
		$productNumber->setAttr('required', '')
				      ->setAttr('data-errortext', 'You can\'t add a new product without a product number')
				      ->setValue($product['product_number']);


		$productName = new Emilk_Form_Element_Text('productName');
		$productName->setAttr('required', '')
				    ->setAttr('data-errortext', 'You can\'t add a new product without a product name')
				    ->setValue($product['product']);


		$price = new Emilk_Form_Element_Number('price');
		$price->setAttr('required', '')
			  ->setAttr('data-errortext', 'You can\'t add a new product without a price')
		      ->setAttr('class', 'decimal')
			  ->setAttr('data-min', '0')
			  ->setValue($product['price']);


		$unit = new Emilk_Form_Element_Text('unit');
		$unit->setAttr('required', '')
			 ->setAttr('data-errortext', 'You can\'t add a new product without a unit')
			 ->setValue($product['unit']);


		$status = new Emilk_Form_Element_Radio('status');
		$status->setAttr('required', '')
			   ->addChoises(array(
				  'available',
				  'out of stock'
			   ))
			   ->setValue($product['status']);


		$description = new Emilk_Form_Element_Textarea('description');
		$description->setValue($product['description']);


		$notes = new Emilk_Form_Element_Textarea('notes');
		$notes->setValue($product['notes']);


		$addProduct = new Emilk_Form_Element_Button('addProduct');
		$addProduct->setAttr('class', 'submit')
				   ->setValue('submit')
				   ->setText('Edit product');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/product/view/' . $this->productId)
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