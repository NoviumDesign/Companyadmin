<?php

class Model_Db_Customers extends Zend_Db_Table_Abstract
{
	protected $_name = 'customers';
    protected $_primary = 'customer_id';
}