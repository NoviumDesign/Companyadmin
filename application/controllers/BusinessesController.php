<?php

class BusinessesController extends Zend_Controller_Action
{
    public function viewAction()
    {
        $db = Zend_Registry::get('db');

        // businesses
        $select = $db->select()
                     ->from('businesses', array('business_id', 'business', 'company_name', 'company_orgnr'));
        $this->view->businesses = $db->fetchAll($select);
    }
}