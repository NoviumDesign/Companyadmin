<?php

class BusinessController extends Zend_Controller_Action
{
    public function addAction()
    {
        $db = Zend_Registry::get('db');

    	$form = new Form_AddBusinessForm();
    	$this->view->form = $form;

    	if($this->_request->isPost()) {
            if($form->isValid()) {

            	$secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);
                $table = new Model_Db_Businesses(array('db' => $db));
                $table->insert(array(
                        'business_secret' => $secret,

                        'business' => $form->getValue('businessName'),

                        'company_name' => $form->getValue('companyName'),
                        'company_adress' => $form->getValue('companyAdress'),
                        'company_box' => $form->getValue('companyBox'),
                        'company_zip_code' => $form->getValue('companyZipCode'),
                        'company_city' => $form->getValue('companyCity'),
                        'company_country' => $form->getValue('companyCountry'),

                        'company_phone' => $form->getValue('companyPhone'),
                        'company_mail' => $form->getValue('companyMail'),
                        'company_site' => $form->getValue('companySite'),

                        'company_bank' => $form->getValue('companyBank'),
                        'company_orgnr' => $form->getValue('companyOrgnr'),

                        'company_color' => substr($form->getValue('companyColor'), -6),
                        'confirmation_mail' => $form->getValue('confirmationMail'),

                        'custom_field_1' => $form->getValue('c1'),
                        'custom_field_2' => $form->getValue('c2'),
                        'custom_field_3' => $form->getValue('c3')
                    ));

                $this->_redirect('/businesses/view');
            }
        }
    }

    public function viewAction()
    {
    	$db = Zend_Registry::get('db');

		$parameters = new Emilk_Request_Parameters();
        list($businessId) = $parameters->get();
        $this->view->businessId = $businessId;

    	$form = new Form_EditBusinessForm();
    	$this->view->form = $form;

    	if($this->_request->isPost()) {
            if($form->isValid()) {

            	$secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);
                $table = new Model_Db_Businesses(array('db' => $db));
                $table->update(array(
                        'business' => $form->getValue('businessName'),

                        'company_name' => $form->getValue('companyName'),
                        'company_adress' => $form->getValue('companyAdress'),
                        'company_box' => $form->getValue('companyBox'),
                        'company_zip_code' => $form->getValue('companyZipCode'),
                        'company_city' => $form->getValue('companyCity'),
                        'company_country' => $form->getValue('companyCountry'),

                        'company_phone' => $form->getValue('companyPhone'),
                        'company_mail' => $form->getValue('companyMail'),
                        'company_site' => $form->getValue('companySite'),

                        'company_bank' => $form->getValue('companyBank'),
                        'company_orgnr' => $form->getValue('companyOrgnr'),

                        'company_color' => substr($form->getValue('companyColor'), -6),
                        'confirmation_mail' => $form->getValue('confirmationMail'),

                        'custom_field_1' => $form->getValue('c1'),
                        'custom_field_2' => $form->getValue('c2'),
                        'custom_field_3' => $form->getValue('c3')
                    ), 'business_id = "' . $businessId . '"');

                $this->_redirect('/businesses/view');
            }
        }
    }

    public function deleteAction()
    {
        $dDb = Zend_Db_Table::getDefaultAdapter();
        $db = Zend_Registry::get('db');

        $parameters = new Emilk_Request_Parameters();
        list($businessId) = $parameters->get();

        $form = new Form_DeleteBusinessForm();
        $this->view->form = $form;


        if($this->_request->isPost()) {
            if($form->isValid()) {
                

                $password = md5($form->getValue('password'));

                $select = $dDb->select()
                              ->from('users', 'id')
                              ->where('password = "' . $password . '"');
                $user = $dDb->fetchAll($select);


                if(count($user)) {

                    // delete



                    print_r($user);


                }
            }
        }

    }
}