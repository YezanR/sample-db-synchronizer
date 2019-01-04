<?php

namespace App;

use PDO;
use App\Synchronizers\SampleTypeSynchronizer;
use App\Repositories\SampleType\SourceDBRepository as SampleTypeSourceDBRepository;
use App\Repositories\SampleType\TargetDBRepository as SampleTypeTargetDBRepository;

class Synchronizer
{
    protected $tableSynchronizers = [];

    public function __construct()
    {
        $this->tableSynchronizers[] = new SampleTypeSynchronizer(new SampleTypeSourceDBRepository(), new SampleTypeTargetDBRepository());
    }

    public function run()
    {
        foreach ($this->tableSynchronizers as $tableSynchronizer) {
            $tableSynchronizer->sync();
        }
    }
}