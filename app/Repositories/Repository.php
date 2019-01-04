<?php

namespace App\Repositories;

interface Repository
{
    public function connect();
    public function all();
    public function find($id, string $idColumnName = 'id');
    public function update($id, array $columns, string $idColumnName = 'id');
}