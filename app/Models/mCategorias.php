<?php

namespace App\Models;

use CodeIgniter\Model;

class mCategorias extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'categorias';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "nombre",
        "descripcion",
        "estado",
        "created_at",
        "updated_at"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nombre'       => "required|alpha_numeric_space|min_length[1]|max_length[255]|is_unique[categorias.nombre, id, {id}]",
        'descripcion'  => 'permit_empty|min_length[1]|max_length[500]',
    ];
    protected $validationMessages   = [
        "nombre" => [
            'is_unique' => 'La categoria <b>{value}</b>, ya se encuentra creada, intente con otro nombre.',
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
