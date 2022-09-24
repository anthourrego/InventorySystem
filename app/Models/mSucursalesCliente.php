<?php

namespace App\Models;

use CodeIgniter\Model;

class mSucursalesCliente extends Model
{
  protected $DBGroup          = 'default';
	protected $table            = 'sucursales';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"nombre",
		"direccion",
		"telefono",
		"administrador",
		"cartera",
		"telefonocart",
		"estado",
    "id_cliente",
		"id_depto",
		"id_ciudad",
		"barrio"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		"nombre" => "required|alpha_numeric_space|min_length[1]|max_length[255]",
		"direccion" => 'required|string|min_length[1]|max_length[300]',
		"administrador" => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		"cartera" => "permit_empty|alpha_numeric_space|min_length[1]|max_length[255]",
		"telefonocart" => "permit_empty|string|min_length[10]|max_length[50]",
		"telefono" => "required|string|min_length[10]|max_length[50]",
    "id_cliente"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[clientes.id]",
		"id_depto"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[departamentos.id]",
		"id_ciudad"=> "permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ciudades.id]",
		"barrio" => 'required|string|min_length[1]|max_length[254]'
	];
	protected $validationMessages   = [];
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
