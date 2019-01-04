<?php

namespace App\Repositories;

abstract class SourceDBRepository extends MsSQLRepository
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
        $tablePrefix = getenv('SOURCE_DB_TABLEPREFIX');
        if ($tablePrefix) {
            $this->tablePrefix = $tablePrefix . ".";
        }
        $this->tableFullName = $this->tablePrefix . $this->table;
    }
}