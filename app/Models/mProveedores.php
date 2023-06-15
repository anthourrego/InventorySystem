<?php

namespace App\Models;

use CodeIgniter\Model;

class mProveedores extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'proveedores';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"nit",
		"nombre",
		"telefono",
		"direccion",
		"contacto",
		"telefonocontacto",
		"id_pais",
		"id_depto",
		"id_ciudad",
		"estado",
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		"nit" =>'required|numeric|min_length[1]|max_length[30]|is_unique[proveedores.nit, id, {id}]',
		"nombre" => "required|alpha_numeric_space|min_length[1]|max_length[255]",
		"direccion" => 'required|string|min_length[1]|max_length[300]',
		"telefono" => "required|string|min_length[10]|max_length[50]",
		"contacto" => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		"telefonocontacto" => "permit_empty|string|min_length[10]|max_length[50]",
		"id_pais"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[paises.id]",
		"id_depto"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[departamentos.id]",
		"id_ciudad"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ciudades.id]",
	];
	protected $validationMessages   = [
		"nit" => [
			'is_unique' => 'El nit <b>{value}</b>, ya se encuentra creado, intente con otro nit.',
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
