<?php

namespace App\Models\Contabilidad;

use CodeIgniter\Model;

class mCatalogoCuentas extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'catalogocuentas';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"codigo",
        "nombre",
		"descripcion",
        "clasificacion",
		"estado",
        "type",
        "id_parent",
		"created_at",
		"updated_at",
		"solo_lectura",
		"eliminable",
		"naturaleza",
		"comportamiento"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'             => "permit_empty|is_natural_no_zero",
		'codigo'         => "required|alpha_numeric_space|min_length[1]|max_length[20]|is_unique[catalogocuentas.codigo, id, {id}]",
        'nombre'         => "required|alpha_numeric_space|min_length[1]|max_length[255]",
		'descripcion'    => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		'naturaleza'     => "required|alpha_numeric_space|min_length[1]|max_length[10]",
		'comportamiento' => "required|alpha_numeric_space|min_length[1]|max_length[10]",
        'clasificacion'  => "required|alpha_numeric_space|min_length[1]|max_length[2]|in_list[CL,GR,CU,SC]",
        'type'           => "required|alpha_numeric_space|min_length[1]|max_length[3]|in_list[CMO,CMA]",
        'id_parent'      => "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[catalogocuentas.id]",
	];
	protected $validationMessages   = [
		"codigo" => [
			'is_unique' => 'El código <b>{value}</b>, ya se encuentra creado, intente con otro.',
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
