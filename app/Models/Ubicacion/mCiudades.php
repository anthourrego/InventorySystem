<?php

namespace App\Models\Ubicacion;

use CodeIgniter\Model;

class mCiudades extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'ciudades';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"nombre",
		"estado",
    "id_depto",
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
		'nombre'       => "required|alpha_numeric_space|min_length[1]|max_length[255]|is_unique[ciudades.nombre, id, {id}]",
    'id_depto'     => "required|numeric|min_length[1]|is_not_unique[departamentos.codigo]",
	];
	protected $validationMessages   = [
		"nombre" => [
			'is_unique' => 'La ciudad <b>{value}</b>, ya se encuentra creada, intente con otro nombre.',
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
