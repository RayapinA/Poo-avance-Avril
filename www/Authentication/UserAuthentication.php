<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 16:32.
 */

namespace Authentication;

use Models\UsersAuthentication;
use Repository\UserRepository;

class UserAuthentication
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(UsersAuthentication $usersAuthentication): void
    {
        $arrayAuthenticationUser = array();
        $arrayAuthenticationUser['email'] = $usersAuthentication->getEmail();

        $arrayDataBaseInfoUser = $this->userRepository->getOneBy($arrayAuthenticationUser);

        $arrayAuthenticationUser['password'] = $usersAuthentication->getPassword();

        if (isset($arrayDataBaseInfoUser['pwd']) &&
            password_verify($arrayAuthenticationUser['password'], $arrayDataBaseInfoUser['pwd'])) {
            session_start();
            $_SESSION['email'] = $arrayDataBaseInfoUser['email'];
            $_SESSION['id'] = $arrayDataBaseInfoUser['id'];

            header('Location: /');
            die();
        }
    }
}
