<?php

class Emilk_Form_Element_Element
{
	public $name = null;
	public $value = null;
	public $attributes = array();
	public $validation = array();


	function __construct($name)
	{
		$this->name = $name;
	}

	public function setValue($value)
	{
		$this->value = $value;

		return $this;
	}

	public function setAttr($attr, $val)
	{
		$this->attributes[$attr] = $val;

		return $this;
	}

	public function setValidation($type, $error = null)
	{
		$this->validation[$type] = $error;

		return $this;
	}
}