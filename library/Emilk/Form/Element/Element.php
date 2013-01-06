<?php

class Emilk_Form_Element_Element
{
	public $type = null;
	public $name = null;
	public $value = array('');
	public $error = array();
	public $attributes = array();
	public $validation = array();


	function __construct($name)
	{
		$start = strrpos(get_class($this), '_', -1);
    	$this->type = lcFirst(substr(get_class($this), $start + 1));

		$this->name = $name;
		$this->attributes['id'] = $name;
	}

	public function setValue($value)
	{
		$this->value[0] = $value;

		return $this;
	}

	public function setValues($array)
	{
		foreach ($array as $key => $value) {
			$this->value[$key] = $value;
		}

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