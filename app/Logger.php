<?php

namespace App;

class Logger
{
    protected $newLinePrefix = "\r\n";

    public function __construct()
    {
        
    }

    public function log(string $message)
    {
        echo $this->newLinePrefix . $message;
    }

    public function setNewLinePrefix(string $newLinePrefix)
    {
        $this->newLinePrefix = $newLinePrefix;
    }
}