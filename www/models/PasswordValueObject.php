<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 23:49
 */

namespace Models;


final class PasswordValueObject
{
    private $password;

    public function __construct(string $password )
    {
        if(!preg_match('#[a-z]#', $password) && !preg_match('#[A-Z]#', $password)
        && !preg_match('#[0-9]#', $password)) {
            throw new \InvalidArgumentException('The password doesn\'t respect the pattern');
        }

        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
    public function Password()
    {
        return $this->password;
    }

}