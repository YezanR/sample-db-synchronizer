<?php

namespace App\Synchronizers;

use App\Logger;
use Carbon\Carbon;
use App\Repositories\SampleType\SourceDBRepository;
use App\Repositories\SampleType\TargetDBRepository;


class SampleTypeSynchronizer extends TableSynchronizer
{
    public function __construct()
    {
        $this->sourceRepository = new SourceDBRepository();
        $this->targetRepository = new TargetDBRepository();
    }

    public function sync()
    {   
        try {
            $records = $this->readData();
            $targetRecordsToKeep = [];
            foreach ($records as $record) {
                $targetRecord = $this->findRecordInTargetDB($record['s_sampletypeid']);
                if ($targetRecord) {
                    // $this->updateRecordInTargetDB($targetRecord, $record);
                    $targetRecordsToKeep[] = $record['s_sampletypeid'];
                }
                else {
                    // $this->insertRecordInTargetDB($record);
                }
                print_r($targetRecord);
            }

            // $this->deleteRecordsInTargetDBExcept($targetRecordsToKeep);

        } catch(Exception $e) {
            Logger::logError("Can't read data from table '$this->sourceTable'");
        }
    }

    private function readData()
    {
        return $this->sourceRepository->all();
    }

    private function findRecordInTargetDB($recordId)
    {
        return $this->targetRepository->find($recordId, 'lims_id');
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
        $queryString = "UPDATE $this->targetTable set name = :name, updated_at = :updated_at where id = " . $targetRecord['id'];
        $query = $this->targetDB->prepare($queryString); 
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $query->execute([
            ':name' => $sourceRecord['sampletypedesc'],
            ':updated_at' => $now
        ]);
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