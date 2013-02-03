<?php

class Emilk_Pdf_Element
{
	// public $parent;
	public $style = 
		array(
			'dimensions' => array(
				'width' => 0,
				'height' => 0
			),
			'margin' => array(
				'top' => 0,
				'right' => 0,
				'bottom' => 0,
				'left' => 0
			),
			'padding' => array(
				'top' => 0,
				'right' => 0,
				'bottom' => 0,
				'left' => 0
			),
			'font' => array(
				'type' => Zend_Pdf_Font::FONT_HELVETICA,
				'size' => 14
			),
			'background' => array(
				'color' => false,
				'image' => false,
				'position' => array(
					'vertical' => 'top',
					'horizontal' => 'left'
				)
			),
			'text' => array(
				'align' => 'left'
			),
			'color' => '#000000',
			'clear' => 'left'
		);
	public $elements = array();
	public $text;

	function __construct()
	{
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

	public function style($string)
	{
		$styles = explode(';', $string);

		// remove empty elements
		$styles = array_filter($styles);

		foreach($styles as $style) {
			
			// explode
			list($key, $value) = explode(':', $style);

			// trim
			$key = trim($key);
			$value = trim($value);

			// convert to number
			if(is_numeric($value)) {
				$value = (float)$value;
			}

			// store
			$path = explode('-', $key);
			$atPath = &$this->style;
			foreach($path as $key) {
			 	$atPath = &$atPath[$key];
			} 

			// if array
			if(is_array($atPath)) {
				// set several values, maybe
				$value = explode(' ', $value);


				$i = 0;
				foreach($atPath as $key => $nointerest) {
					
					$atPath[$key] = $value[$i];

					if(isset($value[$i + 1])) {
						$i++;
					}

				}
			} else {
				// asign value
				$atPath = $value;
			}
		}
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