<?php

namespace App\Repositories;

use PDO;
use App\Logger;

abstract class MySQLRepository implements Repository
{
    protected $db;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $hostname = getenv('TARGET_DB_HOST');
            $dbname = getenv('TARGET_DB_NAME');
            $port = getenv('TARGET_DB_PORT');
            $username = getenv('TARGET_DB_USERNAME');
            $password = getenv('TARGET_DB_PASSWORD');
            $charset = getenv('TARGET_DB_CHARSET');
            $this->db = new PDO("mysql:host=$hostname:$port;dbname=$dbname", $username, $password , array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES $charset"));
            //set the PDO error mode to exception
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            Logger::logMessage("Connected successfully to target DB");
        }
        catch(PDOException $e)
        {
            Logger::logError("Failed to connect to target DB: \r" . $e->getMessage());
        }
    }
}