<?php

namespace App\Repositories\SampleType;

use App\Repositories\Repository;

class SourceStubRepository implements Repository
{
    public function connect() 
    {

    }

    public function all()
    {
        $data = [
            [
                "s_sampletypeid" => "Air",
                "sampletypedesc" => "Air",
            ],
            [
                "s_sampletypeid" => "Controle",
                "sampletypedesc" => "Contrôle",
            ],
            [
                "s_sampletypeid" => "Eau",
                "sampletypedesc" => "Eau",
            ],
            [
                "s_sampletypeid" => "EauPropre",
                "sampletypedesc" => "Eau propre",
            ],
            [
                "s_sampletypeid" => "EauSale",
                "sampletypedesc" => "Eau sale",
            ],
            [
                "s_sampletypeid" => "Enrobé",
                "sampletypedesc" => "Enrobés routiers",
            ],
            [
                "s_sampletypeid" => "EnrobéHAP",
                "sampletypedesc" => "Enrobé pour HAP",
            ],
            [
                "s_sampletypeid" => "Materiaux",
                "sampletypedesc" => "Materiaux",
            ],
            [
                "s_sampletypeid" => "PAH",
                "sampletypedesc" => "Categorie PAH",
            ],
            [
                "s_sampletypeid" => "Poussieres",
                "sampletypedesc" => "Poussiéres",
            ]
        ];

        return $data;
    }

    public function find($id, string $idColumnName = 'id')
    {

    }

    public function update($id, array $columns, string $idColumnName = 'id')
    {

    }

    public function create(array $columns)
    {

    }
}