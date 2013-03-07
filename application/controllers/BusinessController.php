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
                $businessId = $table->insert(array(
                        'business_secret' => $secret,

                        'business' => $form->getValue('businessName'),

                        'company_name' => $form->getValue('companyName'),
                        'company_adress' => $form->getValue('companyAdress'),
                        'company_box' => $form->getValue('companyBox'),
                        'company_zip_code' => $form->getValue('companyZipCode'),
                        'company_city' => $form->getValue('companyCity'),
                        'company_country' => $form->getValue('companyCountry'),

                        'company_reference' => $form->getValue('companyReference'),
                        'company_phone' => $form->getValue('companyPhone'),
                        'company_mail' => $form->getValue('companyMail'),
                        'company_site' => $form->getValue('companySite'),

                        'company_bank' => $form->getValue('companyBank'),
                        'company_orgnr' => $form->getValue('companyOrgnr'),

                        'company_color' => substr($form->getValue('companyColor'), -6),
                        'confirmation_mail' => $form->getValue('confirmationMail'),

                        'invoice_prefix' => $form->getValue('prefix'),
                        'invoice_detail' => $form->getValue('detail'),

                        'custom_field_1' => $form->getValue('c1'),
                        'custom_field_2' => $form->getValue('c2'),
                        'custom_field_3' => $form->getValue('c3'),

                        'invoice_mail_title' => $form->getValue('invoiceMailTitle'),
                        'invoice_mail_content' => $form->getValue('invoiceMailContent')
                    ));
                
                # file
                if(isset($form->getValue('logo')['name'])) {

                    $fileName = $form->getValue('logo')['name'];
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    if($ext == 'jpg' || $ext == 'jpeg') {
                        $company_id = Zend_Auth::getInstance()->getStorage()->read()->company;
                        $path = APPLICATION_PATH . '/companies/' . $company_id . '/logotypes/' . $businessId . '.'. $ext;

                        move_uploaded_file($form->getValue('logo')['tmp_name'], $path);
                    }
                }

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

                        'company_reference' => $form->getValue('companyReference'),
                        'company_phone' => $form->getValue('companyPhone'),
                        'company_mail' => $form->getValue('companyMail'),
                        'company_site' => $form->getValue('companySite'),

                        'company_bank' => $form->getValue('companyBank'),
                        'company_orgnr' => $form->getValue('companyOrgnr'),

                        'company_color' => substr($form->getValue('companyColor'), -6),
                        'confirmation_mail' => $form->getValue('confirmationMail'),

                        'invoice_prefix' => $form->getValue('prefix'),
                        'invoice_detail' => $form->getValue('detail'),

                        'custom_field_1' => $form->getValue('c1'),
                        'custom_field_2' => $form->getValue('c2'),
                        'custom_field_3' => $form->getValue('c3'),

                        'invoice_mail_title' => $form->getValue('invoiceMailTitle'),
                        'invoice_mail_content' => $form->getValue('invoiceMailContent')
                    ), 'business_id = "' . $businessId . '"');

                # file
                if(isset($form->getValue('logo')['name'])) {

                    $fileName = $form->getValue('logo')['name'];
                    $ext = pathinfo($fileName, PATHINFO_EXTENSION);

                    if($ext == 'jpg' || $ext == 'jpeg') {
                        $company_id = Zend_Auth::getInstance()->getStorage()->read()->company;
                        $path = APPLICATION_PATH . '/companies/' . $company_id . '/logotypes/' . $businessId . '.'. $ext;

                        move_uploaded_file($form->getValue('logo')['tmp_name'], $path);
                    }
                }

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

                    // business
                    $table = new Model_Db_Businesses(array('db' => $db));
                    $table->delete('business_id = "' . $businessId . '"');

                    // customers
                    $table = new Model_Db_Customers(array('db' => $db));
                    $table->delete('business = "' . $businessId . '"');

                    // userAccess
                    $table = new Model_Db_UserAccess(array('db' => $db));
                    $table->delete('business = "' . $businessId . '"');

                    // orders, invoices, products, items, prices
                    $db->query(
                        'DELETE orders, items, prices FROM orders
                            LEFT JOIN items ON items.order = orders.order_id
                            LEFT JOIN prices ON prices.price_id = items.price
                        WHERE orders.business = ?;

                        DELETE invoices, items, prices FROM invoices
                            LEFT JOIN items ON items.invoice = invoices.invoice_id
                            LEFT JOIN prices ON prices.price_id = items.price
                        WHERE invoices.business = ?;

                        DELETE products, prices FROM products
                            LEFT JOIN prices ON prices.price_id = products.price
                        WHERE products.business = ?;
                        ',
                        array($businessId, $businessId, $businessId)
                    );

                    // logo
                    $company_id = Zend_Auth::getInstance()->getStorage()->read()->company;
                    $path = APPLICATION_PATH . '/companies/' . $company_id . '/logotypes/' . $businessId . '.';
                    // tests both files
                    unlink($path . 'jpg');
                    unlink($path . 'jpeg');

                    $this->_redirect('/businesses/view');

                }
            }
        }
    }

}