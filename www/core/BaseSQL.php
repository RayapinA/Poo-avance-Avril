<?php
declare(strict_types=1);

namespace Core;
use \PDO;

class BaseSQL
{
    private $pdo;
    private $table;

    public function __construct()
    {
        try {
            $this->pdo = new PDO(DBDRIVER.':host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPWD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die('Erreur SQL : '.$e->getMessage());
        }

        if(strpos(get_called_class(), "\\")){
            $classPathArray = explode("\\", get_called_class());
        }
        $this->table = end($classPathArray);
    }

    public function setId(int $id)
    {
        $this->id = $id;
        $this->getOneBy(['id' => $id]);
    }

    /**
     * @param array $where  the where clause
     *
     * @return array
     */
    public function getOneBy(array $where):array
    {
        $sqlWhere = [];
        foreach ($where as $key => $value) {
            $sqlWhere[] = $key.'=:'.$key;
        }
        $sql = ' SELECT * FROM '.$this->table.' WHERE  '.implode(' AND ', $sqlWhere).';';
        $query = $this->pdo->prepare($sql);

        $query->setFetchMode(PDO::FETCH_ASSOC);
        $query->execute($where);

        if($query->fetch()){
            return $query->fetch();
        }

        return array();



    }

    public function save()
    {
        $dataObject = get_object_vars($this);
        $dataChild = array_diff_key($dataObject, get_class_vars(get_class()));

        if (is_null($dataChild['id'])) {
            $sql = 'INSERT INTO '.$this->table.' ( '.
            implode(',', array_keys($dataChild)).') VALUES ( :'.
            implode(',:', array_keys($dataChild)).')';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        } else {
            $sqlUpdate = [];
            foreach ($dataChild as $key => $value) {
                if ('id' != $key) {
                    $sqlUpdate[] = $key.'=:'.$key;
                }
            }

            $sql = 'UPDATE '.$this->table.' SET '.implode(',', $sqlUpdate).' WHERE id=:id';

            $query = $this->pdo->prepare($sql);
            $query->execute($dataChild);
        }
    }
}
