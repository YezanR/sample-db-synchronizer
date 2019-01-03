<?php

namespace App;

class Logger
{
    protected $newLinePrefix = "\r\n";

    protected $lineSuffix = "\n";

    private static $instance = null;

    public function __construct()
    {
        
    }

    public function log(string $message)
    {
        echo $this->newLinePrefix . $message . $this->lineSuffix;
    }

    public function setNewLinePrefix(string $newLinePrefix)
    {
        $this->newLinePrefix = $newLinePrefix;
    }

    public static function logMessage(string $message)
    {
        $logger = self::getInstance();
        $logger->log($message);
    }

    public static function logError(string $message)
    {
        self::logMessage("Error > $message");
    }

    public static function getInstance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        return new self();
    }
}