<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 23:49.
 */

namespace ValueObject;

final class PasswordValueObject
{
    private $password;

    public function __construct(string $password, string $confirmPassword = null)
    {
        if (!preg_match('#[a-z]#', $password) || !preg_match('#[A-Z]#', $password)
        || !preg_match('#[0-9]#', $password)) {
            throw new \InvalidArgumentException('The password doesn\'t respect the pattern');
        }

        if ($confirmPassword != null && $confirmPassword != $password) {
            throw new \InvalidArgumentException('The password doesn\'t respect the pattern');
        }

        //Need a Review or Need Help on this one
        if( "" != $confirmPassword){
            $this->generatePassword($password);
        } else {
            $this->password = $password;
        }

    }

    public function Password(): string
    {
        return (string) $this->password;
    }

    private function generatePassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }
}
