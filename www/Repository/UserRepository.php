<?php

namespace Repository;

use Core\DataBaseConnectionInterface;
use Models\Users;

class UserRepository
{
    private $dataBaseConnection;
    private $id;

    public function __construct(DataBaseConnectionInterface $dataBaseConnectionInterface)
    {
        $this->dataBaseConnection = $dataBaseConnectionInterface->connect();
    }

    public function setId(int $id)
    {
        $this->id = $id;
        $this->getOneBy(['id' => $id]);
    }

    public function getOneBy(array $where): array
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key.'=:'.$key;
        }
        $sql = ' SELECT * FROM Users WHERE  '.implode(' AND ', $sqlWhere).';';
        $query = $this->dataBaseConnection->prepare($sql);

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute($where);

        if ($query->fetch()) {
            return $query->fetch();
        }

        return array();
    }

    public function saveUser(Users $user)
    {
        $dataObject = get_object_vars($user);
        if (is_null($dataObject['id'])) {
            $sql = 'INSERT INTO Users ( '.
                implode(',', array_keys($dataObject)).') VALUES ( :'.
                implode(',:', array_keys($dataObject)).')';

            $query = $this->dataBaseConnection->prepare($sql);
            $query->execute($dataObject);
        } else {
            $this->UpdateUser($dataObject);
        }
    }

    public function UpdateUser(array $dataObject)
    {
        $sqlUpdate = [];
        foreach ($dataObject as $key => $value) {
            if ('id' != $key) {
                $sqlUpdate[] = $key.'=:'.$key;
            }
        }
        $sql = 'UPDATE Users SET '.implode(',', $sqlUpdate).' WHERE id=:id';
        $query = $this->dataBaseConnection->prepare($sql);
        $query->execute($dataObject);
    }
}
