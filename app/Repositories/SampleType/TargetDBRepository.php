<?php

namespace App\Repositories\SampleType;

use App\Repositories\TargetDBRepository as GenericTargetDBRepository;

class TargetDBRepository extends GenericTargetDBRepository
{
    protected $table = 'sample_types';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function all()
    {
        
    }   
    
    public function find($id, string $idColumnName = 'id')
    {
        $queryString = "SELECT * from $this->tableFullName where $idColumnName = '$id'";

        $query = $this->db->query($queryString); 
        if (!$query) {
            Logger::logError($this->db->errorInfo()[2]);
        }

        return $query->fetch();
    }
}