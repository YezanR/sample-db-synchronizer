<?php

namespace App;

use PDO;

class Synchronizer
{
    protected $sourceDB;

    protected $targetDB;

    private $logger;

    public function __construct()
    {
        $this->logger = new Logger();
        
        $this->connectToSource();
        $this->connectToTarget();
    }

    protected function connectToSource()
    {
        try {
            $hostname = getenv('SOURCE_DB_HOST');
            $dbname = getenv('SOURCE_DB_NAME');
            $port = getenv('SOURCE_DB_PORT');
            $username = getenv('SOURCE_DB_USERNAME');
            $password = getenv('SOURCE_DB_PASSWORD');
            $this->sourceDB = new PDO("dblib:host=$hostname:$port;dbname=$dbname", "$username", "$password");

            $this->logger->log("connected to source DB");
        } catch (PDOException $e) {
            $this->logger->log("Failed to connect to source DB: " . $e->getMessage());
            die();
        }
    }

    protected function connectToTarget()
    {
        try {
            $hostname = getenv('TARGET_DB_HOST');
            $dbname = getenv('TARGET_DB_NAME');
            $port = getenv('TARGET_DB_PORT');
            $username = getenv('TARGET_DB_USERNAME');
            $password = getenv('TARGET_DB_PASSWORD');
            $this->targetDB = new PDO("mysql:host=$hostname:$port;dbname=$dbname", $username, $password , array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
            //set the PDO error mode to exception
            $this->targetDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $this->logger->log("Connected successfully to target DB");
        }
        catch(PDOException $e)
        {
            $this->logger->log("Failed to connect to target DB: \r" . $e->getMessage());
            die();
        }
    }
}