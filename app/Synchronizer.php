<?php

namespace App;

use PDO;
use App\Synchronizers\SampleTypeSynchronizer;

class Synchronizer
{
    protected $tableSynchronizers = [
        SampleTypeSynchronizer::class
    ];

    public function __construct()
    {
        
    }

    public function run()
    {
        foreach ($this->tableSynchronizers as $tableSynchronizer) {
            $instance = new $tableSynchronizer();
            $instance->sync();
        }
    }
}