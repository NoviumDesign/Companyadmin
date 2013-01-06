<?php

class Emilk_Form_Element_Button extends Emilk_Form_Element_Element
{
	public $text = null;

	public function render() {
		$html = '<' . $this->type . ' name="' . $this->name . '" value="' . $this->value[0] . '" ';
		foreach($this->attributes as $key => $value) {
			$html .= $key . '="' . $value . '" ';
		}
		$html .= '>' . $this->text . '</' . $this->type . '>';
		
		echo $html;
	}

	public function setText($text)
	{
		$this->text = $text;

		return $this;
	}
}