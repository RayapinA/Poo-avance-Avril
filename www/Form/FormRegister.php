<?php
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 12:13
 */

namespace Form;

use Core\Routing;

class FormRegister
{
    public function getRegisterForm(): array
    {
        return [
            'config' => [
                'method' => 'POST',
                'action' => Routing::getSlug('Users', 'save'),
                'class' => '',
                'id' => '',
                'submit' => "S'inscrire",
                'reset' => 'Annuler', ],

            'data' => [
                'firstname' => [
                    'type' => 'text',
                    'placeholder' => 'Votre Prénom',
                    'required' => true,
                    'class' => 'form-control',
                    'id' => 'firstname',
                    'minlength' => 2,
                    'maxlength' => 50,
                    'error' => 'Le prénom doit faire entre 2 et 50 caractères',
                ],

                'lastname' => ['type' => 'text', 'placeholder' => 'Votre nom', 'required' => true, 'class' => 'form-control', 'id' => 'lastname', 'minlength' => 2, 'maxlength' => 100,
                    'error' => 'Le nom doit faire entre 2 et 100 caractères', ],

                'email' => ['type' => 'email', 'placeholder' => 'Votre email', 'required' => true, 'class' => 'form-control', 'id' => 'email', 'maxlength' => 250,
                    'error' => "L'email n'est pas valide ou il dépasse les 250 caractères", ],

                'pwd' => ['type' => 'password', 'placeholder' => 'Votre mot de passe', 'required' => true, 'class' => 'form-control', 'id' => 'pwd', 'minlength' => 6,
                    'error' => 'Le mot de passe doit faire au minimum 6 caractères avec des minuscules, majuscules et chiffres', ],

                'pwdConfirm' => ['type' => 'password', 'placeholder' => 'Confirmation', 'required' => true, 'class' => 'form-control', 'id' => 'pwdConfirm', 'confirm' => 'pwd', 'error' => 'Les mots de passe ne correspondent pas'],
            ],
        ];
    }
}