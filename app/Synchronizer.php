<?php

namespace App;

use PDO;
use App\Synchronizers\SampleTypeSynchronizer;
use App\Repositories\SampleType\SourceDBRepository as SampleTypeSourceRepository;
use App\Repositories\SampleType\TargetDBRepository as SampleTypeTargetRepository;
use App\Repositories\Synchronizer\SynchronizerRepository;
use Carbon\Carbon;

class Synchronizer
{
    protected $tableSynchronizers = [];

    protected $repository;

    private $currentSync = null;

    public function __construct()
    {
        $this->tableSynchronizers[] = new SampleTypeSynchronizer(new SampleTypeSourceRepository(), new SampleTypeTargetRepository());
        $this->repository = new SynchronizerRepository();
    }

    public function run()
    {
        $this->markAsStarted();

        foreach ($this->tableSynchronizers as $tableSynchronizer) {
            $tableSynchronizer->sync();
        }

        $this->markAsFinished();
    }

    private function markAsStarted()
    {
        $this->currentSync = $this->repository->create([]);
    }

    private function markAsFinished()
    {
        $this->repository->update($this->currentSync['id'], ['finished_at' => Carbon::now()->format('Y-m-d H:i:s')]);
    }
}