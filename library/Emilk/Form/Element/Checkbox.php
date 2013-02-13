<?php

class Emilk_Form_Element_Checkbox extends Emilk_Form_Element_Element
{
	public $choices = array();

	public function addChoises($choices)
	{
		foreach ($choices as $choice) {
			$this->choices[$choice] = $choice;
		}

		return $this;
	}

	public function render($choice)
	{
		$checked = null;
		if($choice == $this->value[0]) {
			$checked = 'checked="checked"';
		}

		$html = '<input type="' . $this->type . '" name="' . $this->name . '" ' . $checked . ' ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= 'value="' . $this->choices[$choice] . '"';
		$html .= '>';

		echo $html;
	}
}