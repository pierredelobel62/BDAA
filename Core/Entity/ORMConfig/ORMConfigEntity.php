<?php

namespace Core\Entity\ORMConfig;

abstract class ORMConfigEntity {
    public $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function getConfig() : array {
        return $this->config;
    }
}