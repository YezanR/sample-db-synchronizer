<?php

namespace App;

use PDO;
use App\Synchronizers\SampleTypeSynchronizer;
use App\Repositories\SampleType\SourceDBRepository as SampleTypeSourceRepository;
use App\Repositories\SampleType\TargetDBRepository as SampleTypeTargetRepository;

class Synchronizer
{
    protected $tableSynchronizers = [];

    public function __construct()
    {
        $this->tableSynchronizers[] = new SampleTypeSynchronizer(new SampleTypeSourceRepository(), new SampleTypeTargetRepository());
    }

    public function run()
    {
        foreach ($this->tableSynchronizers as $tableSynchronizer) {
            $tableSynchronizer->sync();
        }
    }
}