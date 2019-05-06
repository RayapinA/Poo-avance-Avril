<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-06
 * Time: 20:11
 */

namespace Models;


interface UsersInterface
{
    public function changeEmail(EmailValueObject $email);
    public function changePassword(PasswordValueObject $password);
}