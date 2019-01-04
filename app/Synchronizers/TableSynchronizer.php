<?php

namespace App\Synchronizers;

use App\Logger;
use App\Connectors\DBSourceConnector;
use App\Connectors\DBTargetConnector;

abstract class TableSynchronizer
{
    protected $sourceTable;
    protected $sourceTablePrefix = '';
    protected $targetTable;
    protected $targetTablePrefix = '';

    protected $sourceDB;

    protected $targetDB;

    public function __construct()
    {
        $sourceTablePrefix = getenv('SOURCE_DB_TABLEPREFIX');
        if ($sourceTablePrefix) {
            $this->sourceTablePrefix = $sourceTablePrefix . ".";
        }
        $targetTablePrefix = getenv('TARGET_DB_TABLE_PREFIX');
        if ($targetTablePrefix) {
            $this->targetTablePrefix = $targetTablePrefix . ".";
        }
        $this->connectToSource();
        $this->connectToTarget();
    }

    protected function connectToSource()
    {
        if (!$this->sourceDB) {
            $connector = new DBSourceConnector();
            $this->sourceDB = $connector->connect();
        }
    }

    protected function connectToTarget()
    {
        if (!$this->targetDB) {
            $connector = new DBTargetConnector();
            $this->targetDB = $connector->connect();
        }
    }

    abstract public function sync();
}