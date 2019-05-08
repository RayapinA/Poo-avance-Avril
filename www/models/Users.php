<?php

declare(strict_types=1);

namespace Models;

use ValueObject\EmailValueObject;
use ValueObject\PasswordValueObject;
use ValueObject\IdentityValueObject;
use models\UsersInterface;

class Users implements UsersInterface
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

    public function changeEmail(EmailValueObject $email): void
    {
        $this->email = $email;
    }

    public function changePassword(PasswordValueObject $password): void
    {
        $this->pwd = $password;
    }

    public function changeIdentity(IdentityValueObject $identity): void
    {
        $this->identity = $identity;
    }

}
