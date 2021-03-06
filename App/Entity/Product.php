<?php

namespace App\Entity;

use Core\Entity\ORMEntity;

class Product extends ORMEntity
{
    const TABLE_NAME = 'product';
    const PRIMARY_KEY = 'id';
    public $id;
    public $name;
    
    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

}