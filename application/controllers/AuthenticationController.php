<?php

class AuthenticationController extends Zend_Controller_Action
{
    public function loginAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('');
        }

        $form = new Form_LoginForm();

        $request = $this->getRequest();
        if($request->isPost()) {
            if($form->isValid()) {

                $mail = $form->getValue('mail');
                $password = $form->getValue('password');

                $authAdapter = $this->getAuthAdapter();
                $authAdapter->setIdentity($mail)
                            ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->Authenticate($authAdapter);

                if($result->isValid()) {
                    $identity = $authAdapter->getResultRowObject();



                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);

                    $this->_redirect('');
                } else {
                    $this->view->invalidLogin = 'Invalid mail or password';
                }
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/authentication/login');
    }

    public function businessAction()
    { 
        $id = $this->_request->getParam('id');
        $user = Zend_Auth::getInstance()->getStorage()->read();
        $db = Zend_Registry::get('db');

        $select = $db->select()
                     ->from('user_access', 'COUNT(business) as access')
                     ->where('user = ' . $user->id . ' AND business = ' . $id);
        $result = $db->fetchAll($select);
        $access = $result[0]['access'];

        if($access) {
            $_SESSION['business']  = $id;

            $path = parse_url($_SERVER['HTTP_REFERER'])['path'];
            $path = explode('/', $path);

            $_url = '';
            if(isset($path[1])) {
                $_url .= '/' . $path[1];

                if(isset($path[2])) {
                    $_url .= '/' . $path[2];
                }
            }

            $this->_redirect($_url);
        } else {
            $this->_redirect('/authentication/logout');
        }
    }


    private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('mail')
                    ->setCredentialColumn('password');
                    // ->setCredentialTreatmen();

        return $authAdapter;
    }
}