<?php

class Emilk_Pdf_Element
{
	// public $parent;
	public $style = 
		array(
			'margin' => array(
				'left' => 0,
				'top' => 0,
				'right' => 0,
				'bottom' => 0
			),
			'padding' => array(
				'left' => 0,
				'top' => 0,
				'right' => 0,
				'bottom' => 0
			),
			'dimensions' => array(
				'width' => 0,
				'height' => 0
			),
			'font' => array(
				'type' => Zend_Pdf_Font::FONT_HELVETICA,
				'size' => 14,
				'color' => '#000000'
			),
			'clear' => 'left',
			'background' => 0,
			'text-aligne' => 'left'
		);
	public $elements = array();
	public $text;

	function __construct()
	{
		// store parent for rendering? Needed widths and so on?
		// $this->parent = $parent;

	}

	public function setStyle($style)
	{
		foreach($style as $type => $value) {
			// if array
			if(is_array($value)) {
				// subtypes
				foreach($value as $subType => $value) {
					// overwrite
					$this->style[$type][$subType] = $value;
				}
			} else {
				// overwrite
				$this->style[$type] = $value;
			}
		}

		return $this;
	}

	public function addElement()
	{
		// create new element
		$element = new Emilk_Pdf_Element();

		// add to elements
		$this->elements[] = $element;

		// return element
		return $element;
	}

	public function text($text)
	{
		$this->text = $text;

		return $this;
	}

}