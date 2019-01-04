<?php

namespace App\Synchronizers;

use App\Logger;
use App\Connectors\DBSourceConnector;
use App\Connectors\DBTargetConnector;

abstract class TableSynchronizer
{
    protected $sourceRepository;
    protected $targetRepository;

    abstract public function sync();
}