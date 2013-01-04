<?php
	
class Emilk_Form_Validate {

	// list var
	public $elements = array();

	function __construct($elements)
	{
		foreach($elements as $name => $element) {
			$this->elements[$name] = $element->validation;
		}

		print_r($this->elements);

		$this->validate();
	}

	private function validate() {

		foreach($this->elements as $name => $validation) {


			

			
		}


	}

}