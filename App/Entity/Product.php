<?php

namespace App\Entity;

use Core\Entity\ORMEntity;

class Product extends ORMEntity
{
    const TABLE_NAME = 'product';
    const PRIMARY_KEY = 'id';
    public $id;
    public $field;
    
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getField(): string {
        return $this->field;
    }

    public function setField(string $field): void {
        $this->field = $field;
    }

}