<?php

namespace App\Repositories;

abstract class TargetDBRepository extends MySQLRepository
{
    protected $table;

    protected $tablePrefix = '';

    protected $tableFullName;

    public function __construct()
    {
        $this->resolveTableFullName();
        $this->connect();
    }

    private function resolveTableFullName()
    {
        $tablePrefix = getenv('TARGET_DB_TABLEPREFIX');
        if ($tablePrefix) {
            $this->tablePrefix = $tablePrefix . ".";
        }
        $this->tableFullName = $this->tablePrefix . $this->table;
    }
}