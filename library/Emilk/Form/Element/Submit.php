<?php

class Emilk_Form_Element_Submit
{
	public $name = null;
	public $value = array('');
	public $attributes = array();
	public $validation = array();

		function __construct($name)
		{
			$this->name = $name;
		}
	
	public function render() {
		$html = '<input type="submit" name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= 'value="' . $this->name . '" >';

		echo $html;
	}

	public function setAttr($attr, $val)
	{
		$this->attributes[$attr] = $val;

		return $this;
	}
}