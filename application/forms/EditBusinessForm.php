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
	                    'custom_field_3',
	                    'invoice_prefix',
	                    'invoice_detail',
	                    'company_reference',
	                    'invoice_mail_title',
	                    'invoice_mail_content'
                     ))
                     ->where('business_id = "' . $businessId . '"');
        list($business) = $db->fetchAll($select);


		$businessName = new Emilk_Form_Element_Text('businessName');
		$businessName->setAttr('required', '')
					 ->setValue($business['business']);



		$companyName = new Emilk_Form_Element_Text('companyName');
		$companyName->setValue($business['company_name']);


		$companyAdress = new Emilk_Form_Element_Text('companyAdress');
		$companyAdress->setValue($business['company_adress']);

		$companyBox = new Emilk_Form_Element_Text('companyBox');
		$companyBox->setValue($business['company_box']);

		$companyZipCode = new Emilk_Form_Element_Text('companyZipCode');
		$companyZipCode->setValue($business['company_zip_code']);

		$companyCity = new Emilk_Form_Element_Text('companyCity');
		$companyCity->setValue($business['company_city']);

		$companyCountry = new Emilk_Form_Element_Text('companyCountry');
		$companyCountry->setValue($business['company_country']);


		$logo = new Emilk_Form_Element_File('logo');

		$prefix = new Emilk_Form_Element_Text('prefix');
		$prefix->setValue($business['invoice_prefix']);

		$detail = new Emilk_Form_Element_Text('detail');
		$detail->setValue($business['invoice_detail']);

		$companyBank = new Emilk_Form_Element_Text('companyBank');
		$companyBank->setValue($business['company_bank']);

		$companyOrgnr = new Emilk_Form_Element_Text('companyOrgnr');
		$companyOrgnr->setValue($business['company_orgnr']);



		$companyReference = new Emilk_Form_Element_Text('companyReference');
		$companyReference->setAttr('required', '')
						 ->setValue($business['company_reference']);

		$companyMail = new Emilk_Form_Element_Email('companyMail');
		$companyMail->setValue($business['company_mail']);

		$companyPhone = new Emilk_Form_Element_Text('companyPhone');
		$companyPhone->setValue($business['company_phone']);

		$companySite = new Emilk_Form_Element_Text('companySite');
		$companySite->setValue($business['company_site']);


		$confirmationMail = new Emilk_Form_Element_Textarea('confirmationMail');
		$confirmationMail->setAttr('data-autogrow', 'true')
					 ->setValue($business['confirmation_mail']);


		$companyColor = new Emilk_Form_Element_Color('companyColor');
		$companyColor->setAttr('class', 'color')
					 ->setValue('#' . $business['company_color']);



		$c1 = new Emilk_Form_Element_Text('c1');
		$c1->setValue($business['custom_field_1']);

		$c2 = new Emilk_Form_Element_Text('c2');
		$c2->setValue($business['custom_field_2']);

		$c3 = new Emilk_Form_Element_Text('c3');
		$c3->setValue($business['custom_field_3']);


		$invoiceMailTitle = new Emilk_Form_Element_Text('invoiceMailTitle');
		$invoiceMailTitle->setAttr('required', '')
						 ->setValue($business['invoice_mail_title']);
		
		$invoiceMailContent = new Emilk_Form_Element_Textarea('invoiceMailContent');
		$invoiceMailContent->setAttr('required', '')
						   ->setAttr('data-autogrow', 'true')
						   ->setValue($business['invoice_mail_content']);



		$editBusiness = new Emilk_Form_Element_Button('editBusiness');
		$editBusiness->setAttr('class', 'submit green')
				     ->setValue('submit')
				     ->setText('Edit Business');


		$this->setAttr('id', 'form')
			 ->setAttr('method', 'post')
			 ->setAttr('autocomplete', 'off')
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
				$editBusiness,
				$logo,
				$prefix,
				$detail,
				$companyReference,
				$invoiceMailTitle,
				$invoiceMailContent
			 ));
	}
}