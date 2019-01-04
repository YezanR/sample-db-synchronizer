<?php

namespace App\Synchronizers;

use App\Logger;

abstract class TableSynchronizer
{
    protected $sourceRepository;
    protected $targetRepository;

    abstract public function sync();
}