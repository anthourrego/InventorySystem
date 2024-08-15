<?php

namespace App\Models;

use App\Entities\MovimientoInventarioEntity;
use CodeIgniter\Model;

class MovimientoInventarioModel extends Model
{
	protected $table            = 'movimientosinventario';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $returnType       = MovimientoInventarioEntity::class;
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"id_producto",
		"cantidad",
		"tipo",
		"observacion",
		"id_venta",
		"id_pedido",
		"id_pedido_observacion",
		"id_compra",
		"id_ingresomercancia"
	];

	protected bool $allowEmptyInserts = false;
	protected bool $updateOnlyChanged = true;

	protected array $casts = [];
	protected array $castHandlers = [];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'           						=> "permit_empty|is_natural_no_zero",
		'id_producto'   					=> 'required|numeric|min_length[1]|max_length[11]|is_not_unique[productos.id]',
		'cantidad'     						=> 'required|numeric|min_length[1]|max_length[11]',
		'tipo'       							=> 'required|string|min_length[1]|max_length[2]',
		'observacion'  						=> 'permit_empty|string|min_length[1]|max_length[500]',
		'id_venta'  							=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ventas.id]',
		'id_pedido'  							=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]',
		'id_pedido_observacion'  	=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[observacionproductos.id]',
		'id_compra'  							=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[compras.id]',
		'id_ingresomercancia'  		=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[ingresomercancia.id]'
	];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = ["updateInventory"];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];

	protected	function updateInventory(array $data){
		$dataMovimiento = (object) $data["data"];

		$productoModel = new mProductos(); 

		$product = $productoModel->find($dataMovimiento->id_producto);

		if ($dataMovimiento->tipo === "I") {
			$product["stock"] += $dataMovimiento->cantidad;
		} else {
			$product["stock"] -= $dataMovimiento->cantidad;
		}

		//$product["stock"] = null;

		if(!$productoModel->save($product)){
			$data["data"]["observacion"] = "Error al guardar al actualizar el producto. " . listErrors($productoModel->errors());
		}

		return $data;
	}
}
