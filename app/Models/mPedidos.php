<?php

namespace App\Models;

use CodeIgniter\Model;

class mPedidos extends Model {
	protected $DBGroup          = 'default';
	protected $table            = 'pedidos';
	protected $primaryKey       = 'id';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'object';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		"pedido",
		"id_cliente",
		"id_vendedor",
		"id_sucursal",
		"observacion",
		"impuesto",
		"neto",
		"total",
		"metodo_pago",
		"estado",
		"fin_empaque"
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'           => "permit_empty|is_natural_no_zero",
		'pedido'       => 'required|string|min_length[1]|max_length[20]|is_unique[pedidos.pedido, id, {id}]',
		'id_cliente'   => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[clientes.id]',
		'id_vendedor'  => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
    'id_sucursal'  => 'required|numeric|min_length[1]|max_length[11]|is_not_unique[sucursales.id]',
		'impuesto'     => 'required|decimal|min_length[1]|max_length[20]',
		'neto'         => 'required|decimal|min_length[1]|max_length[20]',
		'total'        => 'required|decimal|min_length[1]|max_length[20]',
		'metodo_pago'  => 'required|string|min_length[1]|max_length[50]',
		'observacion'  => 'permit_empty|string|min_length[1]|max_length[500]',
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

	function cargarPedido($id){
		$pedido = $this->db->table("pedidos AS P")
			->select("
				P.id,
				P.pedido,
				P.id_cliente,
				C.documento AS NroDocumentoCliente,
				C.nombre AS NombreCliente,
				P.id_vendedor,
				U.usuario AS Vendedor,
				U.nombre AS NombreVendedor,
				P.total,
				P.metodo_pago,
				P.observacion,
				P.created_at,
				S.direccion AS Direccion,
				C.telefono,
				P.id_sucursal,
				P.estado,
				S.nombre AS NombreSucursal,
				S.administrador AS AdministradorSucursal,
				S.telefono,
				CI.nombre AS Ciudad,
				DEP.nombre AS Departamento  
			")->join("clientes AS C", "P.id_cliente = C.id", "left")
			->join("usuarios AS U", "P.id_vendedor = U.id", "left")
			->join("sucursales AS S", "P.id_sucursal = S.id", "left")
			->join("ciudades AS CI", "S.id_ciudad = CI.id", "left")
			->join("departamentos AS DEP", "CI.id_depto = DEP.codigo", "left")
			->where("P.id", $id)
			->get()->getResultObject();

		return $pedido;
	}
}
