<?php

class Emilk_Pdf extends Zend_Pdf
{
	function __construct()
	{
		// run parent construct
		parent::__construct();
	}

	public function addPage()
	{
		// create new page
		$page = new Emilk_Pdf_Page(Emilk_Pdf_Page::SIZE_A4);

		// add to pages
		$this->pages[] = $page;

		return $page;
	}
}