<?php

class Emilk_Form
{	
	// list var
	public $name = null;
	public $attributes = array();
	public $elements = array();

	function __construct()
	{
		// get render file name
    	$start = strrpos(get_class($this), '_', -1);
    	$this->name = lcFirst(substr(get_class($this), $start + 1));
	}

	public function setAttr($attr, $val)
	{
		$this->attributes[$attr] = $val;

		return $this;
	}

	public function validate()
	{
		$validation = new Emilk_Form_Validate($this->elements);

		return $validation;	  // true or false
	}

	public function getValues()
	{
		$values = array();
		foreach($this->elements as $element) {
			$values[$element->name] = $element->value;
		}

		return $values;
	}

	public function add($elements)
	{
		foreach($elements as $element) {
			$this->elements[$element->name] = $element;
		}
	}

	public function render()
	{
		$html = '<form name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$hmtl .= '>';


		echo $html;
		require_once APPLICATION_PATH . '/forms/html/' . $this->name . '.php';
		echo '</form>';
	}

	public function element($name)
	{
		return $this->elements[$name]->render();
	}
}