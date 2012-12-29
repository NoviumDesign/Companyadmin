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
            if($form->isValid($this->_request->getPost())) {

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
        $this->_redirect('authentication/login');
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