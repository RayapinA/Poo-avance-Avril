<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-11
 * Time: 01:03.
 */

namespace Form;

use Core\Routing;

class FormForgetPassword
{
    public function getForgetPasswordForm(): array
    {
        return [
            'config' => [
                'method' => 'POST',
                'action' => Routing::getSlug('Users', 'forgetPassword'),
                'class' => '',
                'id' => '',
                'submit' => 'Reset Password',
                ],

            'data' => [
                'email' => ['type' => 'email', 'placeholder' => 'Votre email', 'required' => true, 'class' => 'form-control', 'id' => 'email',
                    'error' => "L'email n'est pas valide", ],
            ],
        ];
    }
}
