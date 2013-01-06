<?php

class Emilk_Form_Element_Password extends Emilk_Form_Element_Element
{
	public function render() {
		$html = '<input type="' . $this->type . '" name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= '>';

		echo $html;
	}
}