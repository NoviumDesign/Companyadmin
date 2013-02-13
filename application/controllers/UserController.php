<?php

class UserController extends Zend_Controller_Action
{
    private $isAdmin = false;

    public function init()
    {
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $acl = new Model_LibraryAcl;
        $adminVal =  array_search('admin', $acl::$roles);
        $roleVal =  array_search($role, $acl::$roles);

        if($roleVal >= $adminVal) {
            $this->isAdmin = true;
        }
    }

	public function addAction()
	{	
		$dDb = Zend_Db_Table::getDefaultAdapter();
		$db = Zend_Registry::get('db');

		$form = new Form_AddUserForm();
        $this->view->form = $form;

        // add user
        if($this->_request->isPost()) {
            if($form->isValid()) {

            	$secret = substr(str_shuffle('abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890abcdefghijlkmnopqrstuvwxyz1234567890'), 0, 10);
				$companyId = Zend_Auth::getInstance()->getStorage()->read()->company;

                $table = new Model_Db_Users(array('db' => $dDb));
                $userId = $table->insert(array(
                        'secret' => $secret,
                        'mail' => $form->getValue('mail'),
                        'password' => md5($form->getValue('password')),
                        'company' => $companyId,
                        'role' => $form->getValue('role'),
                        'name' => $form->getValue('name')
                    ));

                foreach($_POST['access'] as $business => $access) {
                	if($access == 'permitted') {

                		$table = new Model_Db_UserAccess(array('db' => $db));
                		$table->insert(array(
	                        'user' => $userId,
	                        'business' => $business
                    	));

                	}
                }

                $this->_redirect('/users/view');
            }
        }
	}

    public function viewAction()
    {
        $dDb = Zend_Db_Table::getDefaultAdapter();
        $db = Zend_Registry::get('db');

        // get user id from url
        $userId = $this->userId();

        // form
        $role = Zend_Auth::getInstance()->getStorage()->read()->role;
        $form = new Form_EditUserForm($userId, $this->isAdmin, $role);
        $this->view->form = $form;

        if($this->_request->isPost()) {
            if($form->isValid()) {

                $update = array(
                    'name' => $form->getValue('name'),
                    'mail' => $form->getValue('mail')
                );

                // update pass?
                if($form->getValue('password')) {
                    $update['password'] = md5($form->getValue('password'));
                }

                // is admin -> update role
                if($this->isAdmin && ($role == 'master' || $form->getValue('role') != 'master')) {
                    // admin wont be able to set master
                    $update['role'] = $form->getValue('role');
                }

                $table = new Model_Db_Users(array('db' => $dDb));
                $table->update(
                    $update,
                    'id = "' . $userId .'"'
                );

                // is admin -> update access
                if($this->isAdmin) {
                    // remove all
                    $table = new Model_Db_UserAccess(array('db' => $db));
                    $table->delete('user = "' . $userId . '"');

                    // insert
                    foreach($_POST['access'] as $business => $access) {
                        if($access == 'permitted') {

                            $table = new Model_Db_UserAccess(array('db' => $db));
                            $table->insert(array(
                                'user' => $userId,
                                'business' => $business
                            ));

                        }
                    }
                }

                header('Location: /users/view');

            }
        }

    }

    private function userId()
    {
        if($this->isAdmin) {
            $parameters = new Emilk_Request_Parameters();
            list($userSecret) = $parameters->get();

            if($userSecret) {

                $dDb = Zend_Db_Table::getDefaultAdapter();

                // get user id
                $userId = Zend_Auth::getInstance()->getStorage()->read()->id;
                $userRole = Zend_Auth::getInstance()->getStorage()->read()->role;
                $userCompany = Zend_Auth::getInstance()->getStorage()->read()->company;
                $select = $dDb->select()
                              ->from('users', 'id')
                              ->where('
                                     users.secret = "' . $userSecret . '"
                                     AND
                                     (
                                         users.id = "' . $userId . '"
                                         OR
                                         (
                                             users.role <> "god"
                                             AND
                                             users.role <> "master"
                                             AND
                                             users.role <> "' . $userRole . '"
                                         )
                                     )
                                     AND
                                     users.company = "' . $userCompany . '"
                                 ');

                $userId = $dDb->fetchAll($select);

                if(isset($userId[0]['id'])) {
                    $userId = $userId[0]['id'];
                } else {
                    header('Location: /users/view');
                    exit();
                }
            } else {
                $userId = Zend_Auth::getInstance()->getStorage()->read()->id;
            }
        } else {
            $userId = Zend_Auth::getInstance()->getStorage()->read()->id;
        }

        return $userId;
    }
}