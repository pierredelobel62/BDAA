<?php

namespace Core;

class Connection
{
    private static $instance = null;
    private $pdo = null;

    public function __construct()
    {
        $config = parse_ini_file('config/dbconfig.ini');
        $dsn = 'pgsql:host='.$config['hostname'].';dbname='.$config['database'];
        try {
            $this->pdo = new \PDO($dsn, $config['username'], $config['password']);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }
    
    public static function getConnection()
    {
        return self::getInstance()->pdo;
    }

    public static function getNextId(string $table) {
        $pdo = self::getConnection();
        $res = $pdo->query('SELECT MAX(id) + 1 FROM ' . $table);
        $res = $res->fetch();
        return $res[0];
    }
}