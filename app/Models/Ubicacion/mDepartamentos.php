<?php

namespace App\Models\Ubicacion;

use CodeIgniter\Model;

class mDepartamentos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'departamentos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"codigo",
		"nombre",
		"estado",
    "id_pais",
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
		'id'           => "permit_empty|is_natural_no_zero",
		'codigo'       => "required|min_length[1]|max_length[11]|is_unique[departamentos.codigo, id, {id}]",
		'nombre'       => "required|alpha_numeric_space|min_length[1]|max_length[255]|is_unique[departamentos.nombre, id, {id}]",
    'id_pais'      => "required|numeric|min_length[1]|is_not_unique[paises.id]",
	];
	protected $validationMessages   = [
		"nombre" => [
			'is_unique' => 'El departamento <b>{value}</b>, ya se encuentra creado, intente con otro nombre.',
		],
		"codigo" => [
			'is_unique' => 'El codigo <b>{value}</b>, ya se encuentra creado, intente con otro codigo.',
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
