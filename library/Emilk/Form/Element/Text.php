<?php

class Emilk_Form_Element_Text extends Emilk_Form_Element_Element
{
	
	public function render() {
		$html = '<input type="text" name="' . $this->name . '" ';

		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}

		$html .= 'value="' . $this->value[0] . '"';
		$html .= '>';


		echo $html;
	}
}