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

    	$this->build();
	}

	public function setAttr($attr, $val)
	{
		$this->attributes[$attr] = $val;

		return $this;
	}

	public function isValid()
	{
		$validation = new Emilk_Form_Validate($this->elements, $this->name);

		return $validation->valid;
	}

	public function getValue($name)
	{
		if(count($this->elements[$name]->value) == 1) {
			return $this->elements[$name]->value[0];
		} else {
			return $this->elements[$name]->value;
		}
	}

	public function add($elements)
	{
		foreach($elements as $element) {
			$this->elements[$element->name] = $element;
		}

		return $this;
	}

	public function render()
	{
		$this->isValid();

		$html = '<form name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= '>';

		$formIdentifier = '<input type="hidden" name="formIdentifier" value="' . $this->name . '">';

		echo $html . $formIdentifier;
		require_once APPLICATION_PATH . '/forms/html/' . $this->name . '.php';
		echo '</form>';
	}

	public function element($name, $choise = 0)
	{
		if($this->elements[$name]->type == 'radio') {
			$this->elements[$name]->render($choise);
		} else {
			$this->elements[$name]->render();
		}
	}
	public function elementError($name, $htmlBefore = '', $htmlAfter = '')
	{
		if(count($this->elements[$name]->error)) {

			echo $htmlBefore;
			echo '<ul>';

			foreach ($this->elements[$name]->error as $error) {
				echo '<li>' . $error . '</li>';
			}

			echo '</ul>';
			echo $htmlAfter;
		}
	}
}