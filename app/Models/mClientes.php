<?php

namespace App\Models;

use CodeIgniter\Model;

class mClientes extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'clientes';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"nombre",
		"documento",
		"direccion",
		"telefono",
		"administrador",
		"cartera",
		"telefonocart",
		"compras",
		"ultima_compra",
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
		"documento" =>'permit_empty|numeric|min_length[1]|max_length[30]|is_unique[clientes.documento, id, {id}]',
		"nombre" => "required|alpha_numeric_space|min_length[1]|max_length[255]",
		"direccion" => 'required|string|min_length[1]|max_length[300]',
		"telefono" => "required|string|min_length[10]|max_length[50]",
		"administrador" => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		"cartera" => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		"telefonocart" => "permit_empty|string|min_length[10]|max_length[50]"
	];
	protected $validationMessages   = [
		"documento" => [
			'is_unique' => 'El número de documento <b>{value}</b>, ya se encuentra creada, intente con otro documento.',
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
