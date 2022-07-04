<?php

namespace App\Models;

use CodeIgniter\Model;

class mObservacionProductos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'observacionproductos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_pedido_producto",
		"motivo",
    "observacion",
		"cantidad_anterior",
		"cantidad_actual",
		"valor_anterior",
		"valor_actual"
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id_pedido_producto'  => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[pedidosproductos.id]',
		'motivo'              => 'required|numeric|min_length[1]|max_length[11]',
		'observacion' 	     	=> 'permit_empty|string|min_length[1]|max_length[500]',
		'cantidad_anterior'  	=> 'required|numeric|min_length[1]|max_length[11]',
		'cantidad_actual'    	=> 'required|numeric|min_length[1]|max_length[11]',
    'valor_anterior'     	=> 'required|decimal|min_length[1]|max_length[20]',
		'valor_actual'       	=> 'required|decimal|min_length[1]|max_length[20]',
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
