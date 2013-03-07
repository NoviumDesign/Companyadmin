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
                $password = md5($form->getValue('password'));

                $authAdapter = $this->getAuthAdapter();
                $authAdapter->setIdentity($mail)
                            ->setCredential($password);

                $auth = Zend_Auth::getInstance();
                $result = $auth->Authenticate($authAdapter);

                if($result->isValid()) {
                    $identity = $authAdapter->getResultRowObject();

                    $authStorage = $auth->getStorage();
                    $authStorage->write($identity);

                    $this->_redirect('/authentication/business');
                } else {
                    $this->view->invalidLogin = 'Invalid mail or password';
                }
            }
        }
        $this->view->form = $form;

        if($_SESSION['access_denied']) {
            echo '<div style="display:none">';
            print_r($_SESSION['access_denied']);
            echo '</div>';
        }

    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        unset($_SESSION['business']);
        $this->_redirect('/authentication/login');
    }

    public function businessAction()
    { 
        $parameters = new Emilk_Request_Parameters();
        list($businessId) = $parameters->get();

        $user = Zend_Auth::getInstance()->getStorage()->read();
        $db = Zend_Registry::get('db');

        // sent from change business or login?
        if($businessId > 1) {
            $select = $db->select()
                         ->from('user_access', 'COUNT(business) as access')
                         ->where('user = ' . $user->id . ' AND business = ' . $businessId);
            $result = $db->fetchAll($select);
            $access = $result[0]['access'];

            if($access) {
                $_SESSION['business']  = $businessId;

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
        } else {
            $select = $db->select()
                         ->from('user_access', 'MIN(business) as business')
                         ->where('user_access.user = "' . $user->id . '"');
            list($businessId) = $db->fetchAll($select);

            $userRole = Zend_Auth::getInstance()->getStorage()->read()->role;
            if(!$businessId['business'] && ($userRole == 'god' || $userRole == 'master')) {

                // select first business
                $select = $db->select()
                             ->from('businesses', 'MIN(business_id) as business');
                list($businessId) = $db->fetchAll($select);

                if(!$businessId['business']) {
                    $_SESSION['business'] = 1;
                    $this->_redirect('/business/add');
                }

            }

            if($businessId['business']) {
                $_SESSION['business'] = $businessId['business'];
                $this->_redirect('/');
            } else {
                $this->_redirect('/authentication/logout');
            }
        }
    }


    private function getAuthAdapter()
    {
        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                    ->setIdentityColumn('mail')
                    ->setCredentialColumn('password');

        return $authAdapter;
    }
}