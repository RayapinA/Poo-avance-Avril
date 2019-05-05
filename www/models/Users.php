<?php

declare(strict_types=1);

namespace Models;

use models\EmailValueObject;
use models\PasswordValueObject;
use models\IdentityValueObject;

class Users
{
    public $id = null;
    public $firstname;
    public $lastname;
    public $email;
    public $pwd;
    public $role = 1;
    public $status = 0;
    public $identity;

    public function __construct(EmailValueObject $email, PasswordValueObject $password, IdentityValueObject $identity)
    {
        $this->email = $email;
        $this->pwd = $password;
        $this->identity = $identity;
    }

    public function setFirstname(String $firstname)
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname(String $lastname)
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function setPwd(String $pwd)
    {
        $this->pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    public function setRole(String $role)
    {
        $this->role = $role;
    }

    public function setStatus(String $status)
    {
        $this->status = $status;
    }

    public function changeEmail(EmailValueObject $email)
    {
        $this->email = $email;
    }

    public function changePassword(PasswordValueObject $password)
    {
        $this->pwd = $password;
    }
}
