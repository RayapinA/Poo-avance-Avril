<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 16:32.
 */

namespace Authentication;

use Core\DataBaseConnectionInterface;
use Core\View;

class UserAuthentication
{
    private $dataBaseConnection;

    public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface)
    {
        $this->dataBaseConnection = $dataBaseConnectionInterface->connect();
    }

    public function Authenticate($data): void
    {
        $sqlAuthentication = [];
        foreach ($data as $key => $value) {
            $sqlAuthentication[] = $key.'=:'.$key;
        }

        $sql = ' SELECT * FROM Users WHERE email = :email ';

        $query = $this->dataBaseConnection->prepare($sql);
        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->bindParam(':email', $data['email'], \PDO::PARAM_STR);
        $query->execute();
        $array = $query->fetchAll();

        if (password_verify($data['pwd'], $array[0]['pwd'])) {
            session_start();
            $_SESSION['email'] = $data['email'];
            $_SESSION['id'] = $array[0]['id'];

            $v = new View('homepage', 'back');
            $v->assign('pseudo', 'prof');
        }
    }
}
