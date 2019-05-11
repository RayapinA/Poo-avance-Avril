<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: AR_Gwada
 * Date: 2019-05-04
 * Time: 14:43.
 */

namespace Core;

use PDO;

class DataBaseConnection implements DataBaseConnectionInterface
{
    private $pdo;
    private $table;

    public function __construct(string $driver, string $host, string $name, string $user, string $password)
    {
        try {
            $this->pdo = new PDO($driver.':host='.$host.';dbname='.$name, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur SQL : '.$e->getMessage());
        }

        if (strpos(get_called_class(), '\\')) {
            $classPathArray = explode('\\', get_called_class());
        }
        $this->table = end($classPathArray);
    }

    public function connect(): object
    {
        return $this->pdo;
    }
}
