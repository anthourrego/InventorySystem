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
		"id_pedido",
		"fecha_vencimiento",
		"descuento",
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [
		'id'            		=> "permit_empty|is_natural_no_zero",
		'codigo'        		=> 'required|string|min_length[1]|max_length[20]|is_unique[ventas.codigo, id, {id}]',
		'id_cliente'    		=> 'required|numeric|min_length[1]|max_length[11]|is_not_unique[clientes.id]',
		'id_vendedor'   		=> 'required|numeric|min_length[1]|max_length[11]|is_not_unique[usuarios.id]',
		'id_sucursal'   		=> 'required|numeric|min_length[1]|max_length[11]|is_not_unique[sucursales.id]',
		'impuesto'      		=> 'required|decimal|min_length[1]|max_length[20]',
		'neto'          		=> 'required|decimal|min_length[1]|max_length[20]',
		'total'         		=> 'required|decimal|min_length[1]|max_length[20]',
		'metodo_pago'   		=> 'required|string|min_length[1]|max_length[50]',
		'observacion'   		=> 'permit_empty|string|min_length[1]|max_length[500]',
		'id_pedido'     		=> 'permit_empty|numeric|min_length[1]|max_length[11]|is_not_unique[pedidos.id]',
		'fecha_vencimiento'     => 'required|string|min_length[1]|max_length[10]|',
		'descuento'     		=> 'required|decimal|min_length[1]|max_length[20]',
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
		$subQuery = $this->db->table("abonosventas AS AV")
			->select("
				AV.id_venta
				, SUM(CASE WHEN AV.estado = 'CO' THEN AV.valor ELSE 0 END) AS TotalAbonosVenta
			")
			->groupBy("AV.id_venta")->getCompiledSelect();

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
				V.id_sucursal,
				S.direccion AS Direccion,
				S.nombre AS NombreSucursal,
				S.administrador AS AdministradorSucursal,
				S.telefono,
				CI.nombre AS Ciudad,
				DEP.nombre AS Departamento,
				DATE_FORMAT(V.fecha_vencimiento, '%Y-%m-%d') AS FechaVencimiento,
				V.descuento,
				IF(TA.TotalAbonosVenta IS NULL, 0, TA.TotalAbonosVenta) AS AbonosVenta,
				((V.total) - IF(TA.TotalAbonosVenta IS NULL, 0, TA.TotalAbonosVenta)) AS ValorPendiente
			")->join("clientes AS C", "V.id_cliente = C.id", "left")
			->join("usuarios AS U", "V.id_vendedor = U.id", "left")
			->join("sucursales AS S", "V.id_sucursal = S.id", "left")
			->join("ciudades AS CI", "S.id_ciudad = CI.id", "left")
			->join("departamentos AS DEP", "CI.id_depto = DEP.codigo", "left")
			->join("({$subQuery}) TA", "V.id = TA.id_venta", "left")
			->where("V.id", $id)
			->get()->getResultObject();

		return $venta;
	}
}
