<?php

namespace App\Synchronizers;

use App\Connectors\DBSourceConnector;
use App\Connectors\DBTargetConnector;
use App\Logger;
use App\Utils\ArrayUtils;
use Carbon\Carbon;


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
        try {
            $records = $this->readData();
            $targetRecordsToKeep = [];
            foreach ($records as $record) {
                $targetRecord = $this->findRecordInTargetDB($record['s_sampletypeid']);
                if ($targetRecord) {
                    $this->updateRecordInTargetDB($targetRecord, $record);

                    $targetRecordsToKeep[] = $record['s_sampletypeid'];
                }
                else {
                    $this->insertRecordInTargetDB($record);
                }
            }

            $this->deleteRecordsInTargetDBExcept($targetRecordsToKeep);

        } catch(Exception $e) {
            Logger::logError("Can't read data from table '$this->sourceTable'");
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
        
        while ($record = $query->fetch()) {
            $data[] = $record;
        }

        return $data;
    }

    private function findRecordInTargetDB($recordId)
    {
        $queryString = "SELECT * from $this->targetTable where lims_id = '$recordId'";

        $query = $this->targetDB->query($queryString); 
        if (!$query) {
            Logger::logError($this->targetDB->errorInfo()[2]);
        }

        return $query->fetch();
    }

    private function deleteRecordsInTargetDBExcept(array $recordIds)
    {
        $queryExcept = '';
        if (count($recordIds) > 0) {
            $in = str_repeat('?,', max(1, count($recordIds))  - 1) . '?';
            $queryExcept = "where lims_id NOT IN ($in)";
        }
        $queryString = "UPDATE $this->targetTable set deleted_at = NOW() $queryExcept";
        $query = $this->targetDB->prepare($queryString); 
        $query->execute($recordIds);
    }

    private function updateRecordInTargetDB($targetRecord, $sourceRecord)
    {
        $queryString = "UPDATE $this->targetTable set name = :name where id = " . $targetRecord['id'];
        $query = $this->targetDB->prepare($queryString); 
        $query->execute([':name' => $sourceRecord['sampletypedesc']]);
    }

    private function insertRecordInTargetDB($record)
    {
        $queryString = "INSERT INTO $this->targetTable (lims_id, name, created_at, updated_at) VALUES (:lims_id, :name, :created_at, :updated_at)";
        $query = $this->targetDB->prepare($queryString);
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $query->execute([
            ':lims_id' => $record['s_sampletypeid'], 
            ':name' => $record['sampletypedesc'],
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);
        
    }
}