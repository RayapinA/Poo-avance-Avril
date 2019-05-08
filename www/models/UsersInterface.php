<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-06
 * Time: 20:11
 */

namespace Models;


use ValueObject\IdentityValueObject;
use ValueObject\PasswordValueObject;
use ValueObject\EmailValueObject;

interface UsersInterface
{
    public function changeEmail(EmailValueObject $email);
    public function changePassword(PasswordValueObject $password);
    public function changeIdentity(IdentityValueObject $identity);
}