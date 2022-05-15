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
        'referencia'   => "required|alpha_numeric_punct|min_length[1]|max_length[255]|is_unique[productos.referencia, id, {id}]",
        'item'         => 'required|alpha_numeric_punct|min_length[1]|max_length[255]',
        'descripcion'  => 'permit_empty|alpha_numeric_punct|min_length[1]|max_length[500]',
        'stock'        => 'required|numeric|min_length[1]|max_length[11]',
        'precio_venta' => 'required|decimal|min_length[1]|max_length[20]',
        'ubicacion'    => 'permit_empty|alpha_numeric_punct|min_length[1]|max_length[255]',
        'manifiesto'   => 'permit_empty|alpha_numeric_punct|min_length[1]|max_length[255]',
        'ventas'       => 'permit_empty|integer|min_length[1]|max_length[11]',
        'estado'       => 'permit_empty|integer|min_length[1]|max_length[1]',
    ];
    protected $validationMessages   = [
        "referencia" => [
            'is_unique' => 'Le referencia <b>{value}</b>, ya se encuentra creado, intente con otra referencia.',
        ],
        "item" => [
            'is_unique' => 'El ítem <b>{value}</b>, ya se encuentra creado, intente con ítem nombre.',
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
