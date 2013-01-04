<?php

class Emilk_Form_Element_Text extends Emilk_Form_Element_Element
{
	
	public function render() {
		$html = '<input type="text" name="' . $this->name . '" ';

		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}

		if($this->value)
			$html .= 'value="' . $this->value . '"';

		$hmtl .= '>';


		echo $html;
	}
}