<?php

namespace Controllers;

use Core\View;
use Core\Validator;
use Models\Users;
use Manager\userManager;
use Controllers\UserPersistenceManager;
use Form\FormRegister;
use Form\FormLogin;

class UsersController
{
    private $userManager;
    private $user;

    public function __construct(UserManager $userManager)
    {
        $this->user = new Users();
        $this->userManager = $userManager;
    }

    public function defaultAction()
    {
        echo 'users default';
    }

    public function addAction()
    {
        $objectFormRegister = new FormRegister();
        $form = $objectFormRegister->getRegisterForm();

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
    }

    public function saveAction()
    {
        $user = new Users();
        $objectFormLogin = new FormLogin();
        $form = $objectFormLogin->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {

            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $this->user->setFirstname($data['firstname']);
                $this->user->setLastname($data['lastname']);
                $this->user->setEmail($data['email']);
                $this->user->setPwd($data['pwd']);

                $this->userManager->save($this->user);
            }
        }

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
    }

    public function loginAction()
    {
        $objectFormLogin = new FormLogin();
        $form = $objectFormLogin->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $token = md5(substr(uniqid().time(), 4, 10).'mxu(4il');
                // TODO: connexion
            }
        }

        $view = new View('loginUser', 'front');
        $view->assign('form', $form);
    }

    public function forgetPasswordAction()
    {
        $view = new View('forgetPasswordUser', 'front');
    }
}
