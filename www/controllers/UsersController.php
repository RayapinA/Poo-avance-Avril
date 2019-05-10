<?php

declare(strict_types=1);

namespace Controllers;

use Authentication\UserAuthentication;
use Core\View;
use Form\FormForgetPassword;
use Models\Users;
use Models\UsersAuthentication;
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
        session_start();
        var_dump($_SESSION);
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
        //For redirection after save
        $objectFormLogin = new FormLogin();
        $form = $objectFormLogin->getLoginForm();

        $method = strtoupper($form['config']['method']); //Same as Register is POST
        $data = $GLOBALS['_'.$method];

        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            //Maybe i should implement a factory for User
            $identity = new IdentityValueObject($data['firstname'], $data['lastname']);
            $email = new EmailValueObject($data['email']);
            $password = new PasswordValueObject($data['pwd'], $data['pwdConfirm']);

            //TODO : gestion des exceptions
            $user = new Users($email, $password, $identity);
            $this->userManager->save($user);
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
            //$token = md5(substr(uniqid().time(), 4, 10).'mxu(4il');

            $email = new EmailValueObject($data['email']);
            $password = new PasswordValueObject($data['pwd']);
            $userAuthentication = new UsersAuthentication($email, $password);

            $this->userAuthentication->authenticate($userAuthentication);
        }
        $view = new View('loginUser', 'front');
        $view->assign('form', $form);
    }

    public function forgetPasswordAction(): void
    {
        $objectFormLogin = new FormForgetPassword();
        $form = $objectFormLogin->getForgetPasswordForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_'.$method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $email = new EmailValueObject($data['email']);
            //TODO gerer l'exception et faire traitement envoie de mail
            header('Location: /');
            die();
        }
        $view = new View('forgetPasswordUser', 'front');
        $view->assign('form', $form);
    }
}
