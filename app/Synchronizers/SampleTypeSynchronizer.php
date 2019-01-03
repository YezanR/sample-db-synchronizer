<?php

namespace App\Synchronizers;

use App\Connectors\DBSourceConnector;
use App\Connectors\DBTargetConnector;
use App\Logger;


class SampleTypeSynchronizer extends TableSynchronizer
{
    protected $sourceTable = 's_sampletype';
    protected $targetTable = 'sample_types';

    public function __construct()
    {
        parent::__construct();

        $this->sourceTable = $this->sourceTablePrefix . $this->sourceTable;
        $this->targetTable = $this->targetTablePrefix . $this->targetTable;
    }

    public function sync()
    {
        $this->connectToSource();
        
        try {
            $data = $this->readData();
            print_r($data);
        } catch(Exception $e) {
            Logger::logError("Can't read data from table $this->sourceTable");
        }
    }

    private function readData()
    {
        $data = [];

        $queryString = "SELECT s_sampletypeid, sampletypedesc from $this->sourceTable"; 
        $query = $this->sourceDB->query($queryString); 
        if (!$query) {
            Logger::logError($this->sourceDB->errorInfo()[2]);
        }
        
        while ($row = $query->fetch()) {
            $data[] = $row;
        }

        return $data;
    }
}