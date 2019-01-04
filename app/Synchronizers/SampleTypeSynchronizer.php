<?php

namespace App\Synchronizers;

use App\Logger;
use Carbon\Carbon;
use App\Repositories\SampleType\SourceDBRepository;
use App\Repositories\SampleType\TargetDBRepository;
use App\Repositories\Repository;

class SampleTypeSynchronizer extends TableSynchronizer
{
    public function __construct(Repository $sourceRepository, Repository $targetRepository)
    {
        $this->sourceRepository = $sourceRepository;
        $this->targetRepository = $targetRepository;
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
        return $this->sourceRepository->all();
    }

    private function findRecordInTargetDB($recordId)
    {
        return $this->targetRepository->find($recordId, 'lims_id');
    }

    private function deleteRecordsInTargetDBExcept(array $recordIds)
    {
        $this->targetRepository->deleteAllExcept($recordIds, 'lims_id');
    }

    private function updateRecordInTargetDB($targetRecord, $sourceRecord)
    {
        $columns = [
            'name' => $sourceRecord['sampletypedesc']
        ];

        $this->targetRepository->update($targetRecord['id'], $columns);
    }

    private function insertRecordInTargetDB($record)
    {
        $columns = [
            'lims_id' => $record['s_sampletypeid'], 
            'name' => $record['sampletypedesc'],
        ];

        $this->targetRepository->create($columns);
    }
}