<?php

class Emilk_Pdf_Page extends Zend_Pdf_Page
{
	public $elements = array();

	function __construct($option)
	{
		// run parent construct
		parent::__construct($option);
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

	public function renderPage($element = false, $pos = false, $space = false)
	{
		if($element == false) {
			// first run

			// apply grandparent elements
			$elements = $this->elements;

			// set absolute position
			$pos = new stdClass();
				$pos->x = 0;
				$pos->y = 0;

			$space = new stdClass();
				$space->w = $this->getWidth();
				$space->h = $this->getHeight();
		} else {
			$elements = $element;
		}

		// for new line x coord
		$posLeft = $pos->x;


		// loop through each child
		// store highest hight for "new line"
		$highestElem = 0;
		$usedSpace = 0;
		foreach($elements as $elem) {
			// echo $pos->x .'<br>';

			// required width and height
			$required = new stdClass();
				$required->w = $elem->style['dimensions']['width']
							 + $elem->style['margin']['left']
							 + $elem->style['margin']['right'];
				$required->h = $elem->style['dimensions']['height']
					 		 + $elem->style['margin']['top']
					 		 + $elem->style['margin']['bottom'];

			// fit?
			if($elem->style['clear'] == 'left' || $required->w > ($space->w - $usedSpace)) {
				// move position to "new line"
				$pos->y += $highestElem;
				$pos->x = $posLeft;

				// reset used sapce
				$usedSpace = 0;
			}

			// draw self
			// add margin to position
			$drawPos = new stdClass();
				$drawPos->x = $pos->x + $elem->style['margin']['left'];
				$drawPos->y = $pos->y + $elem->style['margin']['top'];

			// print_r($drawPos);
			// echo '<br>';

			// draw element
			// get text height
			$textHeight = $this->renderElem($drawPos, $space, $elem);

			// echo $textHeight . '<br>';

			// grandchildren?
			if(count($elem->elements) > 0) {
				// add padding
				$drawPos->x += $elem->style['padding']['left'];
				$drawPos->y += $elem->style['padding']['top'] + $textHeight;
				// element dimensions
				$elemDim = new stdClass();
					$elemDim->w = $elem->style['dimensions']['width'] - $elem->style['padding']['left'] - $elem->style['padding']['right'];
					$elemDim->h = $elem->style['dimensions']['height'] - $elem->style['padding']['top'] - $elem->style['padding']['bottom'];
				// recursive
				$drawPos = $this->renderPage($elem->elements, $drawPos, $elemDim);
			}


			// FOR NEXT RUN

			// highest element/text in row
			if($required->h > $highestElem) {
				$highestElem = $required->h;
			}

			if($textHeight > $highestElem) {
				// echo 123123123;
				$highestElem = $textHeight;
			}
			// echo ' - ' . $highestElem . '<br>';

			// move cursor for next elem
			$pos->x += $required->w;

			// increase used space
			$usedSpace += $required->w;
		}

		return $pos;
	}

	private function renderElem($pos, $pageDimm, $elem)
	{
		// page dimensions
		$pageDim = new stdClass();
			$pageDim->w = $this->getWidth();
			$pageDim->h = $this->getHeight();

		// store
		$style = $elem->style;
		$text = $elem->text;

		// element dimensions
		// padding left already included in pos
		$elemDim = new stdClass();
			$elemDim->w = $style['dimensions']['width'] - $style['padding']['right'];
			$elemDim->h = $style['dimensions']['height'] - $style['padding']['bottom'];

		// coords
		// top left
		$p1 = new stdClass();
			$p1->x = $pos->x;
			$p1->y = $pageDim->h - $pos->y;
		// bottom right
		$p2 = new stdClass();
			$p2->x = $pos->x + $elemDim->w + $style['padding']['right'];
			$p2->y = $pageDim->h - $pos->y - $elemDim->h - $style['padding']['bottom'];

		if($style['background']['color']) {
			// color

			$color = $style['background']['color'];
    		$this->setFillColor(Zend_Pdf_Color_Html::color($color));

			// origo = (0,0) = (left, bottom)
			$this->drawRectangle(
				$p1->x,	// left
				$p2->y,	// bottom
				$p2->x,	// right
				$p1->y,	// top
				Zend_Pdf_Page::SHAPE_DRAW_FILL
			); 
		}






		if($style['background']['image']) {
			// MAKE POSITIONS WORK
			// path
			$imgPath = APPLICATION_PATH . $style['background']['image'];

			// dimensions
			$imgSize = getimagesize($imgPath);

			// load image 
			$image = Zend_Pdf_Image::imageWithPath($imgPath); 


			if($imgSize[0]/$imgSize[1] > ($p2->x - $p1->x)/($p1->y - $p2->y)) {
				// image wider

				$this->drawImage(
					$image,
					$p1->x,	// left
					$p1->y - $imgSize[1]*($p2->x - $p1->x)/$imgSize[0],	// bottom
					$p2->x,	// right
					$p1->y	// top
				); 

			} else {
				// image higher

				$this->drawImage(
					$image,
					$p1->x,	// left
					$p2->y,	// bottom
					$p1->x + $imgSize[0]*($p1->y - $p2->y)/$imgSize[1],	// right
					$p1->y	// top
				); 
			}




			// draw image 
			// $this->drawImage(
			// 	$image,
			// 	$p1->x,	// left
			// 	$p1->y + $imgSize[1],	// bottom
			// 	$p1->x + $imgSize[0],	// right
			// 	$p1->y	// top
			// ); 
		}






		// add padding img before <--------------------------------------------------------
		$p1->x += $style['padding']['left'];
		$p1->y -= $style['padding']['top'];

		if(strlen(trim($text)) > 0) {
			// correct position, stick to width, new line, break-line (long word), sense new line in text?, align


			// font
			$font = new stdClass();
				$font->type = $style['font']['type'];
				$font->size = $style['font']['size'];
				$font->color = $style['color'];

			// restriction
			$res = new stdClass();
				// minus padding right + top?
				$res->w = $p2->x - $p1->x;
				$res->h = $p1->y; - $p2->y;

			// write text
			$lines = $this->calculateText($text, $font, $res, $p1);

			// print_r($lines);

			// draw string
			foreach($lines as $i => $line) {

				// color
				$this->setFillColor(Zend_Pdf_Color_Html::color($font->color));

				// Set font 
				$this->setFont(Zend_Pdf_Font::fontWithName($font->type), $font->size);

				// text-align
				if($style['text']['align'] == 'right') {
					// push text to right
					$push = $elemDim->w - $line['width'];
				} elseif($style['text']['align'] == 'center') {
					// center push
					$push = ($elemDim->w - $line['width'])/2;
				} else {
					$push = 0;
				}

				// Draw text
				$this->drawText(
					$line['text'],
					$p1->x + $push,	// align
					$p1->y - $font->size*($i*1.2 + 1)*0.93,	// add for each row
					'UTF-8'
				); 
	
			}
		}

		// text height
		if(isset($lines) && count($lines) > 0) {
			$l = count($lines) - 1;
			return $font->size*($l*0.95 + 1)*1.17;
		} else {
			return 0;
		}
	}

	private function calculateText($string, $font, $restriction, $position) {

		// font
		$fontSize = $font->size;
		$_font = Zend_Pdf_Font::fontWithName($font->type);

		// converting characters which the font does not have to similarities.
		// $string = iconv('UTF-8', 'UTF-8//IGNORE', $string);


		// space length
		$spaceLength = $_font->glyphNumbersForCharacters(array(ord(' ')));
		$spaceLength = $_font->widthsForGlyphs($spaceLength);
		$spaceLength = (array_sum($spaceLength)/$_font->getUnitsPerEm()) * $fontSize;

		// array
		$string = str_replace('[br]', ' [br] ', $string); // make sure its a word
		$string = preg_replace('/\s+/', ' ', $string); // replace double '  ' with ' '
		$string = explode(' ', $string);
		$lineWidth = 0;
		$line = '';
		$lines = array();
		foreach($string as $word) {

			// check if <br>
			if($word == '[br]') {
				$nl = true;
			} else {
				$nl = false;
			}

			// for each char in string
			$characters = array();
			foreach(str_split($word) as $char) {
				// ascii numbers for each letter
				$characters[] = ord($char);
			}

			// gylphs
			$glyphs = $_font->glyphNumbersForCharacters($characters);

			// width
			$widths = $_font->widthsForGlyphs($glyphs);

			// string width
			$wordWidth = (array_sum($widths)/$_font->getUnitsPerEm()) * $fontSize;

			if($nl || $lineWidth + $wordWidth > $restriction->w) {
				// new line

				// otherwise first line somtimes will become empty
				if($line) {
					// store for draw
					$lines[] = array('text' => substr_replace($line, '', -1), 'width' => $lineWidth - $spaceLength);	// removes last ' '
				}

				// reset line width and line but add current word or else it will disapear
				if(!$nl) {
					$line = $word . ' ';
					$lineWidth = $wordWidth + $spaceLength;
				} else {
					$line = '';
					$lineWidth = 0;
				}
			} else {
				// next word
				// add
				$line .= $word . ' ';
				$lineWidth += $wordWidth + $spaceLength;
			}
		}
		// add last line
		if($lineWidth) {
			$lines[] = array('text' => substr_replace($line, '', -1), 'width' => $lineWidth - $spaceLength);	// removes last ' '
		}

		return $lines;
	}

	public function build($string) {
		// remove first "<"
		$string = substr(trim($string), 1);

		// make sure <br> wont be elements
		$string = str_replace('<br>', '[br]', $string);

		// split elem
		$elemA = explode('<', $string);

		// recursive
		$this->buildRecursive($elemA, $this);
	}

	private function buildRecursive($array, $who)
	{
		// make queue
		$stack = new Emilk_Stack();
		foreach($array as $key => $elemS) {

			// if element
			$firstLetter = $elemS[0];
			if(trim($elemS) && $firstLetter != '/' && $stack->isEmpty()) {
				// only get siblings and not children
				$stack->add('elem');

				// new element
				$elem = $who->addElement();

				// element attributes
				$elemEnd = strrpos($elemS, '>', -0);
				$elemAttr = trim(substr($elemS, 0, $elemEnd));
				$elemText = trim(substr($elemS, $elemEnd + 1));

				$elem->text($elemText);
				$elem->style($elemAttr);

				// rest of array
				$arrayRest = array_slice($array, $key + 1);

				// recursive
				$this->buildRecursive($arrayRest, $elem);

			} elseif($firstLetter == '/') {
				if($stack->isEmpty()) {
					// parent end tag => exit funktion
					return;
				} else {
					// remove
					$stack->get();
				}
			} else {
				// child elements
				$stack->add('elem');
			}
		}
	}

}