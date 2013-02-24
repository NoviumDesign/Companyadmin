<?php

class Form_AddBusinessForm extends Emilk_Form
{
	public function build()
	{
		$businessName = new Emilk_Form_Element_Text('businessName');
		$businessName->setAttr('required', '')
				     ->setAttr('class', 'autocomplete');



		$companyName = new Emilk_Form_Element_Text('companyName');
		$companyName->setAttr('class', 'autocomplete');

		$companyAdress = new Emilk_Form_Element_Text('companyAdress');
		$companyAdress->setAttr('class', 'autocomplete');

		$companyBox = new Emilk_Form_Element_Text('companyBox');
		$companyBox->setAttr('class', 'autocomplete');

		$companyZipCode = new Emilk_Form_Element_Text('companyZipCode');
		$companyZipCode->setAttr('class', 'autocomplete');

		$companyCity = new Emilk_Form_Element_Text('companyCity');
		$companyCity->setAttr('class', 'autocomplete');

		$companyCountry = new Emilk_Form_Element_Text('companyCountry');
		$companyCountry->setAttr('class', 'autocomplete');



		$logo = new Emilk_Form_Element_File('logo');

		$prefix = new Emilk_Form_Element_Text('prefix');
		$prefix->setAttr('class', 'autocomplete');

		$companyBank = new Emilk_Form_Element_Text('companyBank');
		$companyBank->setAttr('class', 'autocomplete');

		$companyOrgnr = new Emilk_Form_Element_Text('companyOrgnr');
		$companyOrgnr->setAttr('class', 'autocomplete');

		$companyColor = new Emilk_Form_Element_Color('companyColor');
		$companyColor->setAttr('class', 'autocomplete color');



		$companyMail = new Emilk_Form_Element_Email('companyMail');
		$companyMail->setAttr('class', 'autocomplete');

		$companyPhone = new Emilk_Form_Element_Text('companyPhone');
		$companyPhone->setAttr('class', 'autocomplete');

		$companySite = new Emilk_Form_Element_Text('companySite');
		$companySite->setAttr('class', 'autocomplete');



		$confirmationMail = new Emilk_Form_Element_Textarea('confirmationMail');
		$confirmationMail->setAttr('data-autogrow', 'true');


		$c1 = new Emilk_Form_Element_Text('c1');
		$c1->setAttr('class', 'autocomplete');

		$c2 = new Emilk_Form_Element_Text('c2');
		$c2->setAttr('class', 'autocomplete');

		$c3 = new Emilk_Form_Element_Text('c3');
		$c3->setAttr('class', 'autocomplete');



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
				$logo
			 ));
	}
}