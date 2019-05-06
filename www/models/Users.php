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

    public function changeEmail(EmailValueObject $email): void
    {
        $this->email = $email;
    }

    public function changePassword(PasswordValueObject $password): void
    {
        $this->pwd = $password;
    }
}
