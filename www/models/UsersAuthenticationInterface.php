<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-08
 * Time: 14:39
 */

namespace Models;


interface UsersAuthenticationInterface
{
    public function getEmail();
    public function getPassword();
}