<?php

namespace App\Models;

use CodeIgniter\Model;

class mPedidosProductos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'pedidosproductos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_pedido",
    "pedido",
		"id_producto",
		"cantidad",
		"valor",
		"valor_original"
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id_pedido'      => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]',
    'pedido'         => 'required|min_length[1]|max_length[20]|is_not_unique[pedidos.pedido]',
		'id_producto'    => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[productos.id]',
		'cantidad'       => 'required|numeric|min_length[1]|max_length[11]',
		'valor'          => 'required|decimal|min_length[1]|max_length[20]',
		'valor_original' => 'required|decimal|min_length[1]|max_length[20]',
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
