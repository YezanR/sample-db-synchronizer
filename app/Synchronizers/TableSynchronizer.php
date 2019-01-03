<?php

namespace App\Synchronizers;

use App\Logger;
use App\Connectors\DBSourceConnector;
use App\Connectors\DBTargetConnector;

abstract class TableSynchronizer
{
    protected $sourceTable;
    protected $sourceTablePrefix;
    protected $targetTable;
    protected $targetTablePrefix;

    protected $sourceDB;

    protected $targetDB;

    public function __construct()
    {
        $this->sourceTablePrefix = getenv('SOURCE_DB_TABLEPREFIX') . ".";
        $this->targetTablePrefix = getenv('TARGET_DB_TABLE_PREFIX') . ".";
    }

    protected function connectToSource()
    {
        $connector = new DBSourceConnector();
        $this->sourceDB = $connector->connect();
    }

    protected function connectToTarget()
    {
        $connector = new DBTargetConnector();
        $this->targetDB = $connector->connect();
    }

    abstract public function sync();
}