<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductosModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'productos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id_categoria",
        "referencia",
        "item",
        "descripcion",
        "imagen",
        "stock",
        "precio_venta",
        "ubicacion",
        "manifiesto",
        "ventas",
        "estado"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'id_categoria' => "required|integer|min_length[1]",
        'nombre'       => "required|alpha_numeric_space|min_length[1]|max_length[255]|is_unique[perfiles.nombre, id, {id}]",
        'descripcion'  => 'permit_empty|min_length[1]|max_length[500]',
    ];
    protected $validationMessages   = [
        "nombre" => [
            'is_unique' => 'El perfil <b>{value}</b>, ya se encuentra creado, intente con otro nombre.',
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
