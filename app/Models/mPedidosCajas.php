<?php

namespace App\Models;

use CodeIgniter\Model;

class mPedidosCajas extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'pedidoscajas';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_pedido",
    "numero_caja",
		"id_empacador",
		"inicio_empaque",
		"fin_empaque",
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'             => "permit_empty|is_natural_no_zero",
		'id_pedido'      => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]',
    'numero_caja'    => 'required|numeric|min_length[1]|max_length[11]',
		'id_empacador'   => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
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
