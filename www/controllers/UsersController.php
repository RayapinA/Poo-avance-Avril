<?php

declare(strict_types=1);

namespace Controllers;

use Authentication\UserAuthentication;
use Core\View;
use Core\Validator;
use Models\Users;
use Manager\userManager;
use Form\FormRegister;
use Form\FormLogin;
use ValueObject\EmailValueObject;
use ValueObject\PasswordValueObject;
use ValueObject\IdentityValueObject;

class UsersController
{
    private $userManager;
    private $userAuthentication;

    public function __construct(UserManager $userManager, UserAuthentication $userAuthentication)
    {
        $this->userManager = $userManager;
        $this->userAuthentication = $userAuthentication;
    }

    public function defaultAction(): void
    {
        echo 'users default';
    }

    public function addAction(): void
    {
        $objectFormRegister = new FormRegister();
        $form = $objectFormRegister->getRegisterForm();

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
    }

    public function saveAction(): void
    {
        $objectFormLogin = new FormLogin();
        $form = $objectFormLogin->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                //Maybe i should implement a factory for User
                $identity = new IdentityValueObject($data['firstname'], $data['lastname']);
                $email = new EmailValueObject($data['email']);
                $password = new PasswordValueObject($data['pwd']);

                $user = new Users($email, $password, $identity);
                $this->userManager->save($user);
            }
        }

        $view = new View('addUser', 'front');
        $view->assign('form', $form);
    }

    public function loginAction(): void
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
                $this->userAuthentication->Authenticate($data);
            }
        }

        $view = new View('loginUser', 'front');
        $view->assign('form', $form);
    }

    public function forgetPasswordAction(): void
    {
        $view = new View('forgetPasswordUser', 'front');
    }
}
