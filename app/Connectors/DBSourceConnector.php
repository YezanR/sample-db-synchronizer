<?php

namespace App\Connectors;

use PDO;
use App\Logger;

class DBSourceConnector
{
    public function connect()
    {
        try {
            $hostname = getenv('SOURCE_DB_HOST');
            $dbname = getenv('SOURCE_DB_NAME');
            $port = getenv('SOURCE_DB_PORT');
            $username = getenv('SOURCE_DB_USERNAME');
            $password = getenv('SOURCE_DB_PASSWORD');
            $db = new PDO("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$password");

            Logger::logMessage("connected to source DB");
            
            return $db;
        } catch (PDOException $e) {
            Logger::logError("Failed to connect to source DB: " . $e->getMessage());
        }
    }
}