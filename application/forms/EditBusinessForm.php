<?php

class Form_EditBusinessForm extends Emilk_Form
{
	public function build()
	{
    	$db = Zend_Registry::get('db');

		$parameters = new Emilk_Request_Parameters();
        list($businessId) = $parameters->get();

        $select = $db->select()
        			 ->from('businesses',
        			 array(
	                    'business',
	                    'company_name',
	                    'company_adress',
	                    'company_box',
	                    'company_zip_code',
	                    'company_city',
	                    'company_country',
	                    'company_phone',
	                    'company_mail',
	                    'company_site',
	                    'company_bank',
	                    'company_orgnr',
	                    'company_color',
	                    'confirmation_mail',
	                    'custom_field_1',
	                    'custom_field_2',
	                    'custom_field_3'
                     ))
                     ->where('business_id = "' . $businessId . '"');
        list($business) = $db->fetchAll($select);


		$businessName = new Emilk_Form_Element_Text('businessName');
		$businessName->setAttr('class', 'autocomplete')
				     ->setAttr('required', '')
					 ->setValue($business['business']);



		$companyName = new Emilk_Form_Element_Text('companyName');
		$companyName->setAttr('class', 'autocomplete')
					 ->setValue($business['company_name']);


		$companyAdress = new Emilk_Form_Element_Text('companyAdress');
		$companyAdress->setAttr('class', 'autocomplete')
					 ->setValue($business['company_adress']);

		$companyBox = new Emilk_Form_Element_Text('companyBox');
		$companyBox->setAttr('class', 'autocomplete')
					 ->setValue($business['company_box']);

		$companyZipCode = new Emilk_Form_Element_Text('companyZipCode');
		$companyZipCode->setAttr('class', 'autocomplete')
					 ->setValue($business['company_zip_code']);

		$companyCity = new Emilk_Form_Element_Text('companyCity');
		$companyCity->setAttr('class', 'autocomplete')
					 ->setValue($business['company_city']);

		$companyCountry = new Emilk_Form_Element_Text('companyCountry');
		$companyCountry->setAttr('class', 'autocomplete')
					 ->setValue($business['company_country']);



		$companyBank = new Emilk_Form_Element_Text('companyBank');
		$companyBank->setAttr('class', 'autocomplete')
					 ->setValue($business['company_bank']);

		$companyOrgnr = new Emilk_Form_Element_Text('companyOrgnr');
		$companyOrgnr->setAttr('class', 'autocomplete')
					 ->setValue($business['company_orgnr']);



		$companyMail = new Emilk_Form_Element_Email('companyMail');
		$companyMail->setAttr('class', 'autocomplete')
					 ->setValue($business['company_mail']);

		$companyPhone = new Emilk_Form_Element_Text('companyPhone');
		$companyPhone->setAttr('class', 'autocomplete')
					 ->setValue($business['company_phone']);

		$companySite = new Emilk_Form_Element_Text('companySite');
		$companySite->setAttr('class', 'autocomplete')
					 ->setValue($business['company_site']);



		$confirmationMail = new Emilk_Form_Element_Textarea('confirmationMail');
		$confirmationMail->setAttr('data-autogrow', 'true')
					 ->setValue($business['confirmation_mail']);



		$companyColor = new Emilk_Form_Element_Color('companyColor');
		$companyColor->setAttr('class', 'autocomplete')
					 ->setValue('#' . $business['company_color']);



		$c1 = new Emilk_Form_Element_Text('c1');
		$c1->setAttr('class', 'autocomplete')
					 ->setValue($business['custom_field_1']);

		$c2 = new Emilk_Form_Element_Text('c2');
		$c2->setAttr('class', 'autocomplete')
					 ->setValue($business['custom_field_2']);

		$c3 = new Emilk_Form_Element_Text('c3');
		$c3->setAttr('class', 'autocomplete')
					 ->setValue($business['custom_field_3']);



		$editBusiness = new Emilk_Form_Element_Button('editBusiness');
		$editBusiness->setAttr('class', 'submit green')
				    ->setValue('submit')
				    ->setText('Edit Business');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
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
				$editBusiness
			 ));
	}
}