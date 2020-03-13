<?php

namespace Core\Entity\ORMConfig;

class Category extends ORMConfigEntity {
    public function __construct()
    {
        parent::__construct([
            "id" => [
                "type" => "serial",
                "primary_key" => true,
                "nullable" => false
            ],
            "name" => [
                "type" => "varchar(50)",
                "nullable" => false,
                "unique" => true
            ]
        ]);
    }

}