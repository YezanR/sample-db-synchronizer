<?php

namespace App\Repositories\Synchronizer;

use App\Repositories\TargetDBRepository;
use Carbon\Carbon;

class SynchronizerRepository extends TargetDBRepository
{
    protected $table = 'synchronizations';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function all()
    {
        
    }   
    
    public function find($id, string $idColumnName = 'id')
    {
        
    }

    public function update($id, array $columns, string $idColumnName = 'id')
    {
        $queryString = "UPDATE $this->tableFullName set ";
        foreach ($columns as $column => $value) {
            $queryString .= "$column = ?";
        }
        $queryString .= "updated_at = ? where $idColumnName = $id";
        $query = $this->db->prepare($queryString); 
        $values = array_values($columns);
        $now = Carbon::now()->format('Y-m-d H:i:s');
        array_push($values, $now);
        $query->execute($values);
        return $query->fetchObject();
    }

    public function create(array $columns)
    {
        $queryString = "INSERT INTO $this->tableFullName (failed, started_at, finished_at, created_at, updated_at) VALUES (:failed, :started_at, :finished_at, :created_at, :updated_at)";
        $query = $this->db->prepare($queryString);
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $query->execute([
            ':failed' => $columns['failed'] ?? 0, 
            ':started_at' => $columns['started_at'] ?? $now,
            ':finished_at' => NULL,
            ':created_at' => $now,
            ':updated_at' => $now,
        ]);

        return $query->fetchObject();
    }

    public function getLastSync()
    {
        $queryString = "SELECT max(finished_at) from $this->tableFullName where failed = 0";

        $query = $this->db->query($queryString); 
        if (!$query) {
            Logger::logError($this->db->errorInfo()[2]);
        }

        return $query->fetch();
    }
}