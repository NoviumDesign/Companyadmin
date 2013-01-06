<?php

class Emilk_Form_Element_Textarea extends Emilk_Form_Element_Element
{
	public function render() {
		$html = '<' . $this->type . ' name="' . $this->name . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= '>' . $this->value[0] . '</' . $this->type . '>';
		
		echo $html;
	}
}