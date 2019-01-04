<?php

namespace App\Repositories\SampleType;

use App\Repositories\Repository;
use App\Logger;
use App\Repositories\SourceDBRepository as GenericSourceDBRepository;

class SourceDBRepository extends GenericSourceDBRepository
{
    protected $table = 's_sampletype';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function all()
    {
        $data = [];

        $queryString = "SELECT s_sampletypeid, sampletypedesc from $this->tableFullName"; 
        $query = $this->db->query($queryString); 
        if (!$query) {
            Logger::logError($this->db->errorInfo()[2]);
        }
        
        while ($record = $query->fetch()) {
            $data[] = $record;
        }

        return $data;
    }   
    
    public function find($id, string $idColumnName = 'id')
    {

    }
}