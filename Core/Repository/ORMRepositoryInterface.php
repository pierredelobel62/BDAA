<?php

namespace Core\Repository;

use Core\Entity\ORMEntity;

interface ORMRepositoryInterface {
    public function save(ORMEntity $entity) : void;
    public function get(int $id) : ORMEntity;
    public function getList() : array;
    public function delete($id);
}