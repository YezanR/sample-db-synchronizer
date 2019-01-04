<?php

namespace App\Repositories\SampleType;

use Carbon\Carbon;
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

    public function deleteAllExcept(array $exceptIds, string $idColumnName)
    {
        $queryExcept = '';
        if (count($exceptIds) > 0) {
            $in = str_repeat('?,', max(1, count($exceptIds))  - 1) . '?';
            $queryExcept = "where $idColumnName NOT IN ($in)";
        }

        $queryString = "UPDATE $this->tableFullName set deleted_at = NOW() $queryExcept";
        $query = $this->db->prepare($queryString); 
        $query->execute($exceptIds);
    }

    public function update($id, array $columns, string $idColumnName = 'id')
    {
        $queryString = "UPDATE $this->tableFullName set name = :name, updated_at = :updated_at where $idColumnName = " . $id;
        $query = $this->db->prepare($queryString); 
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $query->execute([
            ':name' => $columns['name'],
            ':updated_at' => $now
        ]);
    }
}