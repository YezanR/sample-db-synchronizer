<?php

namespace App\Repositories;

use PDO;
use App\Logger;

abstract class MsSQLRepository implements Repository
{
    protected $db;

    public function __construct()
    {
        $this->connect();
    }
    
    public function connect()
    {
        try {
            $hostname = getenv('SOURCE_DB_HOST');
            $dbname = getenv('SOURCE_DB_NAME');
            $port = getenv('SOURCE_DB_PORT');
            $username = getenv('SOURCE_DB_USERNAME');
            $password = getenv('SOURCE_DB_PASSWORD');
            $this->db = new PDO("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$password");

            Logger::logMessage("connected to source DB");
        } catch (PDOException $e) {
            Logger::logError("Failed to connect to source DB: " . $e->getMessage());
        }
    }
}