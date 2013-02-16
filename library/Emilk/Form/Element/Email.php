<?php

class Emilk_Form_Element_Email extends Emilk_Form_Element_Element
{
	public function render() {
		$html = '<input type="' . $this->type . '" name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= 'value="' . $this->value[0] . '">';

		echo $html;
	}
}