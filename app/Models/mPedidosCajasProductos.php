<?php

namespace App\Models;

use CodeIgniter\Model;

class mPedidosCajasProductos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'pedidoscajasproductos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_caja",
    "id_producto",
		"cantidad",
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'          => "permit_empty|is_natural_no_zero",
		'id_caja'     => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[pedidoscajas.id]',
		'id_producto' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[productos.id]',
    'cantidad'    => 'required|numeric|min_length[1]|max_length[11]',
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
