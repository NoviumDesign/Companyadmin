<?php

class Form_AddBusinessForm extends Emilk_Form
{
	public function build()
	{
		$businessName = new Emilk_Form_Element_Text('businessName');
		$businessName->setAttr('required', '');

		$companyName = new Emilk_Form_Element_Text('companyName');
	
		$companyAdress = new Emilk_Form_Element_Text('companyAdress');
		
		$companyBox = new Emilk_Form_Element_Text('companyBox');
		
		$companyZipCode = new Emilk_Form_Element_Text('companyZipCode');
		
		$companyCity = new Emilk_Form_Element_Text('companyCity');
		
		$companyCountry = new Emilk_Form_Element_Text('companyCountry');
		

		$logo = new Emilk_Form_Element_File('logo');

		$prefix = new Emilk_Form_Element_Text('prefix');

		$detail = new Emilk_Form_Element_Text('detail');
		
		$companyBank = new Emilk_Form_Element_Text('companyBank');
		
		$companyOrgnr = new Emilk_Form_Element_Text('companyOrgnr');
		
		$companyColor = new Emilk_Form_Element_Color('companyColor');
		$companyColor->setAttr('class', 'color');

		$companyReference = new Emilk_Form_Element_Text('companyReference');
		$companyReference->setAttr('required', '');

		$companyMail = new Emilk_Form_Element_Email('companyMail');
		
		$companyPhone = new Emilk_Form_Element_Text('companyPhone');
		
		$companySite = new Emilk_Form_Element_Text('companySite');
		

		$confirmationMail = new Emilk_Form_Element_Textarea('confirmationMail');
		$confirmationMail->setAttr('data-autogrow', 'true');

		$c1 = new Emilk_Form_Element_Text('c1');
		
		$c2 = new Emilk_Form_Element_Text('c2');
		
		$c3 = new Emilk_Form_Element_Text('c3');


		$invoiceMailTitle = new Emilk_Form_Element_Text('invoiceMailTitle');
		$invoiceMailTitle->setAttr('required', '');

		$invoiceMailContent = new Emilk_Form_Element_Textarea('invoiceMailContent');
		$invoiceMailContent->setAttr('data-autogrow', 'true')
						   ->setAttr('required', '');
		

		$addBusiness = new Emilk_Form_Element_Button('addBusiness');
		$addBusiness->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Add Business');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
			 ->setAttr('action', '/business/add')
			 ->setAttr('enctype', 'multipart/form-data')
			 ->add(array(
			 	$businessName,
				$companyName,
				$companyAdress,
				$companyBox,
				$companyZipCode,
				$companyCity,
				$companyCountry,
				$companyBank,
				$companyOrgnr,
				$companyMail,
				$companyPhone,
				$companySite,
				$confirmationMail,
				$companyColor,
				$c1,
				$c2,
				$c3,
				$addBusiness,
				$prefix,
				$logo,
				$detail,
				$companyReference,
				$invoiceMailTitle,
				$invoiceMailContent
			 ));
	}
}