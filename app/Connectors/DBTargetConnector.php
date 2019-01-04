<?php

namespace App\Connectors;

use PDO;
use App\Logger;

class DBTargetConnector
{
    public function connect()
    {
        try {
            $hostname = getenv('TARGET_DB_HOST');
            $dbname = getenv('TARGET_DB_NAME');
            $port = getenv('TARGET_DB_PORT');
            $username = getenv('TARGET_DB_USERNAME');
            $password = getenv('TARGET_DB_PASSWORD');
            $db = new PDO("mysql:host=$hostname:$port;dbname=$dbname", $username, $password , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            //set the PDO error mode to exception
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            Logger::logMessage("Connected successfully to target DB");

            return $db;
        }
        catch(PDOException $e)
        {
            Logger::logError("Failed to connect to target DB: \r" . $e->getMessage());
        }
    }
}