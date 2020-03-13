<?php

namespace Core\Migration;

use Core\Connection;

class MigrationManager {

    private $config;
    
    public function migrateTable(string $table) {
        $entityCongiPath = 'Core\Entity\ORMConfig\\'. ucfirst(strtolower($table));
        $this->config = (new $entityCongiPath())->getConfig();
        if (!$this->tableExist($table)) {
            $request = "CREATE TABLE " . $table . " (";
            foreach ($this->config as $key => $value) {
                $request .= 
                    $key . " " . $value["type"] . " " . 
                    ( isset($value["primary_key"]) ? ($value["primary_key"] ? "PRIMARY KEY" : "") : "") . " " . 
                    ( isset($value["nullable"]) ? ($value["nullable"] ? "" : "NOT NULL") : "") . " " .
                    ( isset($value["unique"]) ? ($value["unique"] ? "UNIQUE" : "") : "") . ", "; 
            }
            $request = substr($request, 0, strlen($request) - 2);
            $request .= ');';
        } else {
           throw new \Exception("La table que vous demandez existe pas");
           
        }

        var_dump($request);
        $pdo = Connection::getConnection();
        $request = $pdo->query($request);
        var_dump($pdo->errorInfo());
        $res = $request->execute();
    }

    public function tableExist(string $table) {
        $request = "SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'public' AND TABLE_NAME = '". $table."';";
        $pdo = Connection::getConnection();
        $request = $pdo->query($request);
        $res = $request->fetch();
        if ($res === false) {
            return false;
        }
        return true;
    }
}