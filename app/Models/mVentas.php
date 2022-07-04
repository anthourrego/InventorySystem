<?php

namespace App\Models;

use CodeIgniter\Model;

class mVentas extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'ventas';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"codigo",
		"id_cliente",
		"id_vendedor",
		"id_sucursal",
		"observacion",
		"impuesto",
		"neto",
		"total",
		"metodo_pago",
		"id_pedido"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'codigo' => 'required|string|min_length[1]|max_length[20]|is_unique[ventas.codigo, id, {id}]',
		'id_cliente' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[clientes.id]',
		'id_vendedor' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'id_sucursal' => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[sucursales.id]',
		'impuesto' => 'required|decimal|min_length[1]|max_length[20]',
		'neto' => 'required|decimal|min_length[1]|max_length[20]',
		'total' => 'required|decimal|min_length[1]|max_length[20]',
		'metodo_pago' => 'required|string|min_length[1]|max_length[50]',
		'observacion' => 'permit_empty|string|min_length[1]|max_length[500]',
		'id_pedido' => 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]',
	];
	protected $validationMessages   = [
		"codigo" => [
			'is_unique' => 'El codigo <b>{value}</b>, ya se encuentra en uso, intente con otro codigo.',
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

	function cargarVenta($id){
		$venta = $this->db->table("ventas AS V")
			->select("
				V.id,
				V.codigo,
				V.id_cliente,
				C.documento AS NroDocumentoCliente,
				C.nombre AS NombreCliente,
				V.id_vendedor,
				U.usuario AS Vendedor,
				U.nombre AS NombreVendedor,
				V.total,
				V.metodo_pago,
				V.observacion,
				V.created_at,
				C.direccion AS Direccion,
				C.telefono,
				S.nombre AS NombreSucursal
			")->join("clientes AS C", "V.id_cliente = C.id", "left")
			->join("usuarios AS U", "V.id_vendedor = U.id", "left")
			->join("sucursales AS S", "V.id_sucursal = S.id", "left")
			->where("V.id", $id)
			->get()->getResultObject();

		return $venta;
	}
}
