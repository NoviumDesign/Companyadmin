<?php

class Emilk_Form_Element_Textarea extends Emilk_Form_Element_Element
{
	
	public function render() {
		$html = '<textarea name="' . $this->name . '" ';

		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}

		$html .= '>' . $this->value[0] . '</textarea>';

		
		echo $html;
	}
}