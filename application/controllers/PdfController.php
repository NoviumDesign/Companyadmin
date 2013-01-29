<?php

class PdfController extends Zend_Controller_Action
{
	private $pdf;
	private $page;

    public function init()
    {
    	// diable layout and view
    	$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender();

		// create new pdf
		$this->pdf = new Emilk_Pdf();
	}

    public function invoiceAction()
    {
    	// pointers
		$pdf = &$this->pdf;
		$page = &$this->page;

		// add new page to the document 
		$page = $pdf->addPage();

		// wrapper
		$wrapper = $page->addElement()->setStyle(
			array('dimensions'=>array('width'=>595, 'height'=>842),'padding'=>array('left'=>40, 'top'=>40, 'right'=>40)
			)
		);

			// head
			$head = $wrapper->addElement()->setStyle(
				array('dimensions'=>array('width'=>515, 'height'=>120)
				)
			);

				// logo
				$head->addElement()->setStyle(
					array('dimensions'=>array('width'=>155, 'height'=>75),'background'=>'#34388a'
					)
				);

				// invoiceNumberWrap
				$invoiceNumberWrap = $head->addElement()->setStyle(
					array(
						'dimensions'=>array('width'=>360, 'height'=>60),'clear'=>'none'
					)
				);

					// invoice
					$invoiceNumberWrap->addElement()->setStyle(
						array(
							'dimensions'=>array('width'=>360, 'height'=>30),'padding'=>array('top'=>-7),'clear'=>'none','text-align'=>'right','font'=>array('size'=>26, 'color'=>'#646363')
						)
					)->text('Faktura');
					// number
					$invoiceNumberWrap->addElement()->setStyle(
						array(
							'dimensions'=>array('width'=>360, 'height'=>30),'padding'=>array('top'=>-3),'clear'=>'none','text-align'=>'right','font'=>array('size'=>26, 'color'=>'#646363')
						)
					)->text('Nr: 000');

				// border
				$head->addElement()->setStyle(
					array('dimensions'=>array('width'=>515, 'height'=>0.1),'margin'=>array('top'=>44.9),'background'=>'#000000'
					)
				);



		// redner page
		$page->renderPage();



		// headers for file transfer
		header('Content-Disposition: inline; filename = ' . 'result' . '.pdf'); 
		header('Content-type: application/x-pdf'); 

		// render pdf
		echo $pdf->render();
    }
}