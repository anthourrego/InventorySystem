<?php

namespace App\Models;

use CodeIgniter\Model;

class mAfiliados extends Model
{
    protected $table            = 'afiliados';
    protected $primaryKey       = 'terceroid';
    protected $useAutoIncrement = false;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "terceroid",
        "nombre",
		"telefono",
		"correo",
		"fecha_afiliacion",
		"fecha_inicio",
		"created_at",
		"updated_at"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'terceroid'       => "required|alpha_numeric_space|min_length[1]|max_length[30]|is_unique[afiliados.terceroid]",
        'nombre'          => "required|alpha_numeric_space|min_length[1]|max_length[255]",
        'telefono'        => "required|alpha_numeric_space|min_length[1]|max_length[50]",
        'correo'          => "permit_empty|valid_email|max_length[255]",
        'fecha_afiliacion'=> "permit_empty|valid_date",
        'fecha_inicio'    => "permit_empty|valid_date"
    ];
    protected $validationMessages   = [
        "terceroid" => [
            'is_unique' => 'El afiliado con el Tercero <b>{value}</b>, ya se encuentra creado, intente con otro.',
        ],
        "correo" => [
            'valid_email' => 'El correo electrónico debe ser válido.',
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
