<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 12:34.
 */

namespace Form;

use Core\Routing;

class FormLogin
{
    public function getLoginForm(): array
    {
        return [
            'config' => [
                'method' => 'POST',
                'action' => Routing::getSlug('Users', 'login'),
                'class' => '',
                'id' => '',
                'submit' => 'Se connecter',
                'reset' => 'Annuler', ],

            'data' => [
                'email' => ['type' => 'email', 'placeholder' => 'Votre email', 'required' => true, 'class' => 'form-control', 'id' => 'email',
                    'error' => "L'email n'est pas valide", ],

                'pwd' => ['type' => 'password', 'placeholder' => 'Votre mot de passe', 'required' => true, 'class' => 'form-control', 'id' => 'pwd',
                    'error' => 'Veuillez préciser un mot de passe', ],
            ],
        ];
    }
}
