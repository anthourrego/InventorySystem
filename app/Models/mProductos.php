<?php

namespace App\Models;

use CodeIgniter\Model;

class mProductos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'productos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_categoria",
		"referencia",
		"item",
		"descripcion",
		"imagen",
		"costo",
		"stock",
		"precio_venta",
		"precio_venta_dos",
		"ubicacion",
		"id_manifiesto",
		"ventas",
		"estado",
		"cantPaca",
		"updated_at",
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'                => "permit_empty|is_natural_no_zero",
		'id_categoria' 			=> "permit_empty|numeric|min_length[1]|is_not_unique[categorias.id]",
		'referencia'   			=> "required|alpha_numeric_punct|min_length[1]|max_length[255]|is_unique[productos.referencia, id, {id}]",
		'item'         			=> 'permit_empty|min_length[1]|max_length[255]', // |alpha_numeric_punct
		'descripcion'  			=> 'permit_empty|min_length[1]|max_length[500]',
		'stock'        			=> 'required|numeric|min_length[1]|max_length[11]',
		'precio_venta' 			=> 'required|decimal|min_length[1]|max_length[20]',
		'precio_venta_dos' 	=> 'required|decimal|min_length[1]|max_length[20]',
		'costo'        			=> "required|decimal|min_length[1]|max_length[20]",
		'ubicacion'    			=> 'permit_empty|alpha_numeric_punct|min_length[1]|max_length[255]',
		'id_manifiesto'			=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[manifiestos.id]',
		'ventas'       			=> 'permit_empty|integer|min_length[1]|max_length[11]',
		'estado'       			=> 'permit_empty|integer|min_length[1]|max_length[1]',
		'cantPaca'     			=> 'permit_empty|numeric|min_length[1]|max_length[11]'
	];
	protected $validationMessages   = [
		"referencia" => [
			'is_unique' => 'Le referencia <b>{value}</b>, ya se encuentra creado, intente con otra referencia.',
		],
		"item" => [
			'is_unique' => 'El ítem <b>{value}</b>, ya se encuentra creado, intente con ítem nombre.',
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

	public function totalInventario($sumarPedidos = false){
		if ($sumarPedidos) {
			$subQuery = $this->db->table("pedidos AS P")
					->select("PP.id_producto, SUM(PP.cantidad) AS cantidad")
					->join("ventas AS V", "P.id = V.id_pedido", "left")
					->join("pedidosproductos AS PP", "P.id = PP.id_pedido", "inner")
					->where("V.id_pedido IS NULL", null, false)
					->groupBy("PP.id_producto")->getCompiledSelect();

			$this->join("({$subQuery}) PP", "{$this->table}.id = PP.id_producto", "left")
				->select("
					SUM(({$this->table}.stock + IFNULL(PP.cantidad, 0)) * {$this->table}.precio_venta) As valorInventario,
					SUM(({$this->table}.stock + IFNULL(PP.cantidad, 0)) * {$this->table}.costo) As costoInventario
				");
		} else {
			$this->selectSum("({$this->table}.stock * {$this->table}.precio_venta)", "valorInventario")
				->selectSum("({$this->table}.stock * {$this->table}.costo)", "costoInventario");
		}

		$this->where("{$this->table}.estado", "1");
		return $this->asObject()->first();
	}
}
