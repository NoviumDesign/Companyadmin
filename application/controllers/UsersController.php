<?php

class UsersController extends Zend_Controller_Action
{
	public function viewAction()
	{
		$db = Zend_Db_Table::getDefaultAdapter();
		$companyId = Zend_Auth::getInstance()->getStorage()->read()->company;

		$select = $db->select()
					 ->from('users', array('secret', 'name', 'mail', 'role'))
					 ->where('users.company = ' . $companyId . ' AND users.role <> "god"');
		$this->view->users = $db->fetchAll($select);
	}
}