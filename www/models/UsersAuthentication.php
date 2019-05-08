<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-08
 * Time: 14:22.
 */

namespace Models;

use ValueObject\EmailValueObject;
use ValueObject\PasswordValueObject;

class UsersAuthentication implements UsersAuthenticationInterface
{
    private $email;
    private $password;

    public function __construct(EmailValueObject $email, PasswordValueObject $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password->Password();
    }
}
