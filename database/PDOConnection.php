<?php

namespace database;


use interfaces\ConnectionInterface;
use PDO;

class PDOConnection implements ConnectionInterface
{

    private $host;
    private $user;
    private $password;
    private $db;


    public function __construct($host, $user, $password, $db)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->db = $db;
    }

    public function getConnection()
    {
        $dsn = sprintf("mysql:host=%s;dbname=%s", $this->host, $this->db);
        return new PDO($dsn, $this->user, $this->password);
    }
}