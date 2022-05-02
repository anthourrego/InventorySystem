<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModel extends Model {
    protected $DBGroup          = 'default';
    protected $table            = 'ventas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "codigo",
        "id_cliente",
        "id_vendedor",
        "productos",
        "impuesto",
        "neto",
        "total",
        "metodo_pago"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'codigo' => 'required|numeric|min_length[1]|max_length[11]|is_unique[ventas.codigo, id, {id}]',
        'id_cliente' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[clientes.id]',
        'id_vendedor' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
        'productos' => 'required|string|min_length[1]',
        'impuesto' => 'required|decimal|min_length[1]|max_length[20]',
        'neto' => 'required|decimal|min_length[1]|max_length[20]',
        'total' => 'required|decimal|min_length[1]|max_length[20]',
        'metodo_pago' => 'required|string|min_length[1]|max_length[50]',
    ];
    protected $validationMessages   = [
        "codigo" => [
            'is_unique' => 'El codigo <b>{value}</b>, ya se encuentra en uso, intente con otro codigo.',
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

    function cargarVenta($id){

    }
}
