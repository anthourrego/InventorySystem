<?php

namespace App\Models;

use CodeIgniter\Model;

class mCompraProductos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'comprasproductos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_compra",
		"id_producto",
		"cantidad",
		"valor",
		"valor_original",
		"creado_compra",
		"cantPaca",
		"costo",
		"ubicacion",
		"id_categoria",
		"id_manifiesto"
	];

	// Dates
	protected $useTimestamps = true;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'              => "permit_empty|is_natural_no_zero",
		'id_compra'       => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[compras.id]',
		'id_producto'     => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[productos.id]',
		'cantidad'        => 'required|numeric|min_length[1]|max_length[11]',
		'valor'           => 'required|decimal|min_length[1]|max_length[20]',
		'valor_original'  => 'required|decimal|min_length[1]|max_length[20]',
		'ubicacion'       => 'permit_empty|alpha_numeric_punct|min_length[1]|max_length[255]',
		'id_manifiesto'   => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[manifiestos.id]',
		'id_categoria'    => "permit_empty|numeric|min_length[1]|is_not_unique[categorias.id]",
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
