<?php

namespace Core\Repository;

use Core\Entity\ORMEntity;
use Core\Connection;
use ReflectionProperty;

abstract class ORMRepository implements ORMRepositoryInterface
{
    private $rc;
    private $properties;
    private $ENTITY_CLASS;
    private $name;

    public function __construct($entity)
    {
        $this->ENTITY_CLASS = $entity;
        $this->rc = new \ReflectionClass($entity);
        $this->properties = $this->rc->getProperties(\ReflectionProperty::IS_PUBLIC | \ReflectionProperty::IS_PRIVATE);
        $this->name = $this->rc->getConstant('TABLE_NAME');
    }

    public function save(ORMEntity $entity) : void {
        if (!$this->getPrimaryKeyValue($entity)) {
            $this->insert($entity);
        } else {
            $this->update($entity);
        }
    }

    private function insert (ORMEntity $entity) : void {
        $request = 'INSERT INTO ' . $this->name . ' ';
        $this->prepareRequest($entity, $request, true);
    }

    private function update (ORMEntity $entity) : void {
        $request = 'UPDATE ' . $this->name . ' SET ';
        $this->prepareRequest($entity, $request, false);
    }

    private function prepareRequest(ORMEntity $entity,string $request, $insert = true) : void {
        $array = [];
        $toBind = [];
        foreach ($this->properties as $propertie) {
            if ($propertie->getName() !== $this->rc->getConstant('PRIMARY_KEY')) {
                $propertie->setAccessible(true);
                $array[$propertie->getName()] = '?';
                $toBind[] = $propertie->getValue($entity);
            } else {
                $pkValue = $propertie->getValue($entity);
            }
        }

        
        if ($insert) {
            $fields = implode(', ', array_keys($array));
            $values = implode(', ', array_values($array));
            $request .= '(' . $fields . ') VALUES (' . $values . ')';
        } else {
            foreach (array_keys($array) as $key => $value) {
                if ($key !== 0) {
                    $request .= ',';
                }
                $request .= $value . ' = ' . array_values($array)[$key];
            }
            $request .= ' WHERE ' . $this->rc->getConstant('PRIMARY_KEY') . ' = ' . $pkValue;
        }

        $this->executePreparedRequest($request, $toBind);
    }

    private function getPrimaryKeyValue(ORMEntity $entity) {
        $fieldName = $this->rc->getConstant('PRIMARY_KEY');
        return (new ReflectionProperty($this->ENTITY_CLASS, $fieldName))->getValue($entity);
    }

    private function executePreparedRequest(string $request, Array $toBind) : void {
        $pdo = Connection::getConnection();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $request = $pdo->prepare($request);
        $request->execute($toBind);
    }

    public function get(int $id) : ORMEntity {
        $request = 'SELECT * FROM ' . $this->name . ' WHERE id = ' . $id;
        $pdo = Connection::getConnection();
        $request = $pdo->query($request);
        $request->setFetchMode(\PDO::FETCH_CLASS, $this->rc->getName());
        $res = $request->fetch();
        if (!is_a($res, 'Core\Entity\ORMEntity')) {
            throw new \Exception('L\'objet demandé n\'existe pas');
        }
        return $res;
    }

    public function getList() : array
    {
        $request = 'SELECT * FROM ' . $this->name;
        $pdo = Connection::getConnection();
        $request = $pdo->query($request);
        $request->setFetchMode(\PDO::FETCH_CLASS, $this->rc->getName());
        $res = $request->fetchAll();
        return $res;
    }

    public function delete($id) {
        if (!$id) {
            throw new \Exception("Paramètre entré invalide");
        }
        if (is_a($id, 'Core\Entity\ORMEntityInterface')) {
            $id = $this->getPrimaryKeyValue($id);
        }
        $request = 'DELETE FROM ' . $this->name . ' WHERE ' . $this->rc->getConstant('PRIMARY_KEY') . ' = ' . $id;
        $pdo = Connection::getConnection();
        $request = $pdo->query($request);
        $request->setFetchMode(\PDO::FETCH_CLASS, $this->rc->getName());
        $res = $request->fetch();
        return $res;
    }
}