<?php

declare(strict_types=1);

namespace Repository;

use Core\DataBaseConnectionInterface;
use Models\Users;

class UserRepository
{
    private $dataBaseConnection;
    private $id;

    //Dependency Inversion
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
        $sqlWhere = $this->prepareDataForQuery($where, true);

        $sql = ' SELECT * FROM Users WHERE  '.implode(' AND ', $sqlWhere).';';
        $query = $this->dataBaseConnection->prepare($sql);

        $query->setFetchMode(\PDO::FETCH_ASSOC);
        $query->execute($where);

        if ($query->fetch()) {
            return $query->fetch();
        }

        return array();
    }

    public function saveUser(Users $user): void
    {
        $dataObject = get_object_vars($user);

        if (is_null($dataObject['id'])) {
            $firstName = $dataObject['identity']->firstName();
            $lastName = $dataObject['identity']->lastName();
            unset($dataObject['identity']);

            $sql = 'INSERT INTO Users ( '.
                implode(',', array_keys($dataObject)).') VALUES ( :'.
                implode(',:', array_keys($dataObject)).')';

            $query = $this->dataBaseConnection->prepare($sql);

            $password = $dataObject['pwd']->Password();
            $email = $dataObject['email']->__toString();

            $query->bindParam(':id', $dataObject['id']);
            $query->bindParam(':pwd', $password);
            $query->bindParam(':email', $email);
            $query->bindParam(':firstname', $firstName);
            $query->bindParam(':lastname', $lastName);
            $query->bindParam(':role', $dataObject['role']);
            $query->bindParam(':status', $dataObject['status']);

            $query->execute();
        } else {
            $this->UpdateUser($dataObject);
        }
    }

    public function UpdateUser(array $dataObject): void
    {
        $firstName = $dataObject['identity']->firstName();
        $lastName = $dataObject['identity']->lastName();
        unset($dataObject['identity']);

        $sqlUpdate = $this->prepareDataForQuery($dataObject);

        $sql = 'UPDATE Users SET '.implode(',', $sqlUpdate).' WHERE id=:id';
        $query = $this->dataBaseConnection->prepare($sql);

        $password = $dataObject['pwd']->Password();
        $email = $dataObject['email']->__toString();

        $query->bindParam(':id', $dataObject['id']);
        $query->bindParam(':pwd', $password);
        $query->bindParam(':email', $email);
        $query->bindParam(':firstname', $firstName);
        $query->bindParam(':lastname', $lastName);
        $query->bindParam(':role', $dataObject['role']);
        $query->bindParam(':status', $dataObject['status']);

        //I get a error here ! i check my code it's the same as saveUser for password and it's work
        $query->execute($dataObject);
    }

    // This break the S of solid ??
    public function prepareDataForQuery(array $dataObject, bool $withId = false): array
    {
        $arrayWithPreparedData = [];
        foreach ($dataObject as $key => $value) {
            if ('id' == $key && false == $withId) {
                continue;
            }
            $arrayWithPreparedData[] = $key.'=:'.$key;
        }

        return $arrayWithPreparedData;
    }
}
