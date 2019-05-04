<?php

declare(strict_types=1);

namespace Models;

use Core\BaseSQL;
use Core\Routing;

class Users extends BaseSQL
{
    public $id = null;
    public $firstname;
    public $lastname;
    public $email;
    public $pwd;
    public $role = 1;
    public $status = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function setFirstname(String $firstname)
    {
        $this->firstname = ucwords(strtolower(trim($firstname)));
    }

    public function setLastname(String $lastname)
    {
        $this->lastname = strtoupper(trim($lastname));
    }

    public function setEmail(String $email)
    {
        $this->email = strtolower(trim($email));
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

}
